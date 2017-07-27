<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Repository;

use Doctrine\DBAL\Query\QueryBuilder as DoctrineQueryBuilder;
use Leonam\Memed\Entity\Medicament as MedicamentEntity;

class Medicament implements BaseRepository
{
    protected $queryBuilder;
    public function __construct(DoctrineQueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function findAll():array
    {
        $medsQuery = $this->queryBuilder
            ->select('ggrem, nome')
            ->from('medicaments');
        $resultSetMedicaments = $medsQuery->execute();

        $list = [];
        foreach ($resultSetMedicaments as $medicament) {
            $list[] = new MedicamentEntity($medicament['ggrem'], $medicament['nome']);
        }
        return $list;
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