<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Repository;

interface BaseRepository
{
    public function findAll();
    public function findOne(array $criteria);
    public function save(array $data);
    public function update($oldValue, $newValue);
}
