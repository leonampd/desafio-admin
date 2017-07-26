<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Repository;

use Leonam\Memed\Persister\Persister;

class Medicament implements BaseRepository
{
    protected $persister;
    public function __construct(Persister $persister = null)
    {
        $this->persister = $persister;
    }

    public function findAll()
    {
        return [];
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