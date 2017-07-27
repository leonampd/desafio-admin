<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Repository;

use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\Connection as DoctrineConnection;
use Leonam\Memed\Entity\Medicament as MedicamentEntity;

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
                $medicament->setSlug( $row['slug'] )
                    ->setId($row['rowid']);
                $list[] = $medicament;
            }
            return $list;
        } catch (ConnectionException $connection_exception) {
            throw $connection_exception;
        }
    }

    public function findOne(array $criteria)
    {
        // TODO: Implement findOne() method.
    }

    public function save($x)
    {
        // TODO: Implement save() method.
    }

}