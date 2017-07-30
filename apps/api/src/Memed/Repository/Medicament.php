<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Repository;

use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\Connection as DoctrineConnection;
use Leonam\Memed\Entity\Medicament as MedicamentEntity;
use Leonam\Memed\Entity\Historic;
use Psr\Log\InvalidArgumentException;

class Medicament implements BaseRepository
{
    protected $connection;
    public function __construct(DoctrineConnection $connection)
    {
        $this->connection = $connection;
    }

    public function findAll(array $criteria):array
    {
        $list = [];
        try {
//            $rs = $this->connection->fetchAll('SELECT rowid, slug, ggrem, nome FROM medicaments');

            array_walk($criteria, function(&$item, $key){
                $item = '%'.trim($item).'%';
            });
            $queryBuilder = $this->connection->createQueryBuilder();
            $queryBuilder
                ->select('rowid', 'slug', 'ggrem', 'nome')
                ->from('medicaments');
            if (count($criteria) > 0) {
                 $queryBuilder->where(
                     $queryBuilder->expr()->orX(
                         $queryBuilder->expr()->like('nome', $this->connection->quote($criteria['search'], \PDO::PARAM_STR)),
                         $queryBuilder->expr()->like('ggrem', $this->connection->quote($criteria['search'], \PDO::PARAM_STR))
                     )
                 );
            }
            $result = $this->connection->fetchAll($queryBuilder->getSQL());
            foreach ($result as $row) {
                $medicament = new MedicamentEntity($row['ggrem'], $row['nome']);
                $medicament->setSlug($row['slug'])
                    ->setId($row['rowid']);
                $list[] = $medicament;
            }
            return $list;
        } catch (ConnectionException $connectionException) {
            throw $connectionException;
        }
    }

    public function findOne(array $criteria)
    {
        if (array_key_exists('slug', $criteria)) {
            $fields_values[] = $criteria['slug'];
        }

        if (array_key_exists('nome', $criteria)) {
            $fields_values[] = $criteria['nome'];
        }
        try {
            $result = $this->connection
                ->fetchAssoc('SELECT rowid, * FROM medicaments WHERE slug = ? OR nome LIKE ?', $fields_values);
            if ($result) {
                $medicament = new MedicamentEntity($result['ggrem'], $result['nome']);
                $medicament->setSlug($result['slug']);
                $medicament->setId($result['rowid']);
                return $medicament;
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function saveMedicament(MedicamentEntity &$medicament)
    {
        if (! MedicamentEntity::medicamentIsValid($medicament)) {
            throw new InvalidArgumentException('Dados do medicamento inválidos');
        }
        $medicament = MedicamentEntity::createSlugForMedicament($medicament);
        $this->connection->insert(
            'medicaments',
            [
                'slug' => substr($medicament->getSlug(), 0, 50),
                'ggrem' => $medicament->getGgrem(),
                'nome' => $medicament->getNome()
            ]
        );
    }

    public function save(array $data)
    {
        try {
            $medicament = new MedicamentEntity($data['ggrem'], $data['nome']);
            $this->saveMedicament($medicament);
            return $medicament;
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return $exception->getMessage();
        }
    }

    public function getHistoric(MedicamentEntity $medicament): array
    {
        $result = $this->connection
            ->fetchAll(
                'SELECT * FROM historic WHERE medicament_id = ? ORDER BY timestamp DESC',
                array($medicament->getId())
            );

        $historic = [];
        if (!$result) {
            return $historic;
        }

        foreach ($result as $historic_bd) {
            $time = new \DateTime();
            $time->setTimestamp($historic_bd['timestamp']);

            $historicItem = new Historic(
                $medicament,
                $historic_bd['action'],
                $historic_bd['field'],
                $historic_bd['old_value'],
                $historic_bd['new_value'],
                $time
            );
            $historicItem->setUsername($historic_bd['username']);
            $historic[] = $historicItem;
        }
        return $historic;
    }

    public function saveHistoric(Historic $historic)
    {
        try {
            $this->connection->insert(
                'historic',
                [
                    'field' => $historic->getField(),
                    'action' => $historic->getAction(),
                    'new_value' => $historic->getNewValue(),
                    'old_value' => $historic->getOldValue(),
                    'timestamp' => $historic->getDate()->getTimestamp(),
                    'medicament_id' => $historic->getMedicament()->getId(),
                    'username' => $historic->getUsername()
                ]
            );
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function updateMedicament(MedicamentEntity $medicament, array $historicItens)
    {
        try {
            $updates = [];
            foreach ($historicItens as $historic) {
                $updates[ $historic->getField() ] = $historic->getNewValue();
            }
            $this->connection->beginTransaction();
            $this->connection->update(
                'medicaments',
                $updates,
                ['slug' => $medicament->getSlug()]
            );
            foreach ($historicItens as $historic) {
                $this->saveHistoric($historic);
            }
            $this->connection->commit();
            return true;
        } catch (\Exception $exception) {
            $this->connection->rollBack();
            echo $exception->getMessage();
            return false;
        }
    }

    public function update($oldValue, $newValue)
    {
        return $this->updateMedicament($oldValue, $newValue);
    }
}
