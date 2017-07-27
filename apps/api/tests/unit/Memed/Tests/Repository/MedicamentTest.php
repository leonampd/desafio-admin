<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Tests\Repository;

use Leonam\Memed\Entity\Medicament;
use Leonam\Memed\Repository\Medicament as MedicamentRepository;
use Doctrine\DBAL\Query\QueryBuilder as DoctrineQueryBuilder;
use PHPUnit\Framework\TestCase;

class MedicamentTest extends TestCase
{
    public function testIfFindAllReturnsAMedicamentsArray()
    {
        $doctrineQueryBuilder = $this->getMockBuilder(DoctrineQueryBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $doctrineQueryBuilder->method('select')
            ->willReturn($doctrineQueryBuilder);

        $doctrineQueryBuilder->method('from')
            ->willReturn($doctrineQueryBuilder);

        $doctrineQueryBuilder->method('execute')
            ->willReturn([
                ['ggrem' => '1234', 'nome' => 'AAS'],
                ['ggrem' => '1334', 'nome' => 'Paracetamol'],
            ]);

        $repository = new MedicamentRepository($doctrineQueryBuilder);
        $items = $repository->findAll();
        $this->assertInternalType('array', $items);
        $this->assertContainsOnlyInstancesOf(Medicament::class, $items);
    }
}
