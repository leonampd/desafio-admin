<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Resource\Medicaments;

use Leonam\Memed\Repository\Medicaments as MedicamentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Retrieve implements Base
{
    private $repository;
    public function __construct(MedicamentRepository $repository = null)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request = null): JsonResponse
    {
        $json = [
            'data' => [
                ['slug' => 'asdfsdsdsdf123', 'ggrem' => '123', 'nome' => 'AAS'],
                ['slug' => 'asdfsdfdsdf123', 'ggrem' => '321', 'nome' => 'Paracetamol']
            ]
        ];
        return new JsonResponse($json);
    }

}