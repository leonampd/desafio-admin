<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Tests\Repository;

use Leonam\Memed\Entity\Medicament;
use Leonam\Memed\Repository\Medicament as MedicamentRepository;
use Doctrine\DBAL\Connection as DoctrineConnection;
use PHPUnit\Framework\TestCase;

class MedicamentTest extends TestCase
{
    public function testIfFindAllReturnsAMedicamentsArray()
    {
        $doctrineQueryBuilder = $this->getMockBuilder(DoctrineConnection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $doctrineQueryBuilder->method('fetchAll')
            ->willReturn([
                ['rowid' => '1', 'slug' => 'lisdbfn9826234', 'ggrem' => '1234', 'nome' => 'AAS'],
                ['rowid' => '2', 'slug' => 'lisdbfn9826234', 'ggrem' => '1334', 'nome' => 'Paracetamol'],
            ]);

        $repository = new MedicamentRepository($doctrineQueryBuilder);
        $items = $repository->findAll();
        $this->assertInternalType('array', $items);
        $this->assertContainsOnlyInstancesOf(Medicament::class, $items);
    }
}
