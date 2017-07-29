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

    public function findAll():array
    {
        $list = [];
        try {
            $rs = $this->connection->fetchAll('SELECT rowid, slug, ggrem, nome FROM medicaments');

            foreach ($rs as $row) {
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
                'SELECT * FROM historic WHERE medicament_id = ?',
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
                $historic_bd['action'],
                $historic_bd['old_value'],
                $historic_bd['new_value'],
                $time
            );
            $historicItem->setUsername($historic_bd['username'])
                         ->setField($historic_bd['field']);
            $historic[] = $historicItem;
        }
        return $historic;
    }
}
