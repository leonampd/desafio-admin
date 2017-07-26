<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Resource\Medicaments;

use Leonam\Memed\Repository\Medicaments as MedicamentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Create implements Base
{
    private $repository;
    public function __construct(MedicamentRepository $repository = null)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request = null): JsonResponse
    {
        return new JsonResponse(['data' => []]);
    }

}