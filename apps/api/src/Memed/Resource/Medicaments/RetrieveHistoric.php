<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Resource\Medicaments;


use Leonam\Memed\Repository\Medicament as MedicamentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RetrieveHistoric implements Base
{
    protected $medicamentSlug;
    protected $repository;
    /**
     * Base constructor.
     *
     * @param MedicamentRepository|null $repository
     */
    public function __construct(MedicamentRepository $repository = null)
    {
        $this->repository = $repository;
    }

    public function setMedicamentSlug(string $medicamentSlug)
    {
        $this->medicamentSlug = $medicamentSlug;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request|null $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke(Request $request = null): JsonResponse
    {
        if (!$this->medicamentSlug) {
            return new JsonResponse(
                ['error' => ['code' => 404, 'message' => 'Medicament not found']],
                404
            );
        }
        try {
            $medicament = $this->repository->findOne(['slug' => $this->medicamentSlug]);
            $historic = $this->repository->getHistoric($medicament);
            $medicament->setHistoric($historic);

            $historicArray = [];
            foreach ($historic as $item) {
                $historicArray[] = [
                    'username' => $item->getUsername(),
                    'action' => $item->getAction(),
                    'field' => $item->getField(),
                    'old_value' => $item->getOldValue(),
                    'new_value' => $item->getNewValue(),
                    'timestamp' => $item->getField(),
                ];
            }
            return new JsonResponse(
                [
                    'data' => $historicArray
                ]
                , 200
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                [
                    'error' => [
                        'code' => 500,
                        'message' => 'Problemas para recuperar o histórico do medicamento ' . $exception->getMessage()
                    ]
                ],
                500
            );
        }
    }
}