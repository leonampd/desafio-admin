<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Resource\Medicaments;

use Leonam\Memed\Repository\Medicament as MedicamentRepository;
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
        $medicaments = [];
        try {
            $list = $this->repository->findAll();
            foreach ($list as $medicament) {
                $medicaments['data'][] = [
                    'slug' => $medicament->getSlug(),
                    'nome' => $medicament->getNome(),
                    'ggrem' => $medicament->getGgrem()
                ];
            }
            return new JsonResponse($medicaments);
        } catch (\Exception $exception) {
            $json = [
                'data' => [
                    'error' => ['code' => 500, 'message'=> 'Problemas internos no servidor']
                ]
            ];
        }
        return new JsonResponse($json);
    }
}
