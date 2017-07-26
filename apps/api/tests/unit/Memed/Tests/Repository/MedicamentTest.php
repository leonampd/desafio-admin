<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Tests\Repository;

use Leonam\Memed\Entity\Medicament;
use Leonam\Memed\Repository\Medicament as MedicamentRepository;
use PHPUnit\Framework\TestCase;

class MedicamentTest extends TestCase
{
    public function testIfFindAllReturnsAMedicamentsArray()
    {
        $repository = new MedicamentRepository();
        $items = $repository->findAll();
        $this->assertInternalType('array', $items);
        $this->assertContainsOnlyInstancesOf(Medicament::class, $items);
    }
}
