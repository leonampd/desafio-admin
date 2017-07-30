<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Resource\Medicaments;

use Leonam\Memed\Repository\Medicament as MedicamentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Respect\Validation\Validator as v;

class Retrieve implements Base
{
    private $repository;
    public function __construct(MedicamentRepository $repository = null)
    {
        $this->repository = $repository;
    }

    public function __invoke(Request $request = null): JsonResponse
    {
        $search = $request->query->get('search');

        if (v::notEmpty()->validate($search) &&
            !(v::when(v::numeric(), v::positive(), v::stringType())->validate($search))
        ) {
            return new JsonResponse(
                ['error' => ['code' => 400, 'message' => "Invalid search {$search} term"]],
                400
            );
        }

        $criteria = [];
        if (!empty($search)) {
            $criteria['search'] = $search;
        }

        $medicaments = ['data' => []];
        try {
            $list = $this->repository->findAll($criteria);
            foreach ($list as $medicament) {
                $medicaments['data'][] = [
                    'slug' => $medicament->getSlug(),
                    'nome' => $medicament->getNome(),
                    'ggrem' => $medicament->getGgrem(),
                    'data_criacao' => $medicament->getCreatedAt()->format('d/m/Y H:i'),
                    'data_atualizacao' => $medicament->isUpdated() ? $medicament->getUpdatedAt()->format('d/m/Y H:i') : '',
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
