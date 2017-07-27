<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Resource\Medicaments;

use Leonam\Memed\Entity\Medicament;
use Leonam\Memed\Repository\Medicament as MedicamentRepository;
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
        $requestFields['nome'] = $request->request->get('nome');
        $requestFields['ggrem'] = $request->request->get('ggrem');

        $result = $this->repository->save($requestFields);
        $data['error'] = ['code' => '500', 'mensagem' => 'Problemas ao inserir o medicamento'];
        if ($result instanceof Medicament) {
            $data = [];
            $data['slug'] = $result->getSlug();
            $data['ggrem'] = $result->getGgrem();
            $data['nome'] = $result->getNome();
        }
        return new JsonResponse(['data' => $data], 201);
    }
}
