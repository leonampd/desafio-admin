<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Resource\Medicaments;


use Leonam\Memed\Entity\Historic;
use Leonam\Memed\Entity\Medicament;
use Leonam\Memed\Repository\Medicament as MedicamentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Respect\Validation\Validator as v;

class Update implements Base
{
    /**
     * @var \Leonam\Memed\Repository\Medicament
     */
    protected $repository;

    /**
     * @var string
     */
    protected $medicamentSlug;

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
     * @return \Symfony\Component\HttpFoundation\3JsonResponse
     */
    public function __invoke(Request $request = null): JsonResponse
    {
        if (!$this->medicamentSlug || !v::alnum()->validate($this->medicamentSlug)) {
            return new JsonResponse(
                ['error' => ['code' => 400, 'message' => 'Invalid id for medicament']],
                404
            );
        }

        $medicament = $this->repository->findOne(['slug' => $this->medicamentSlug]);
        $medicamentUpdated = new Medicament();
        $update = [];

        $nomeInput = $request->request->get('nome') ?? '';
        if (
            !empty($nomeInput) &&
            v::alnum()->validate($nomeInput) &&
            $nomeInput !== $medicament->getNome()
        ) {
            $medicamentUpdated->setNome($nomeInput);
            $historic = new Historic(
                $medicament,
                Historic::UPDATE,
                'nome',
                $medicament->getNome(),
                $medicamentUpdated->getNome()
            );
            $historic->setUsername('Memed Admin');
            $update[] = $historic;
        }

        $ggremInput = $request->request->get('ggrem') ?? '';
        if (
            !empty($ggremInput) &&
            v::numeric()->positive() &&
            $ggremInput !== $medicament->getGgrem()
        ) {
            $medicamentUpdated->setGgrem($ggremInput);
            $historic = new Historic(
                $medicament,
                Historic::UPDATE,
                'ggrem',
                $medicament->getGgrem(),
                $medicamentUpdated->getGgrem()
            );
            $historic->setUsername('Memed Admin');
            $update[] = $historic;
        }
        $medicamentIsUpdated = false;
        if (count($update) > 0) {
            $medicamentIsUpdated = $this->repository->update($medicament, $update);
        }
        return new JsonResponse(
            ['data' => ['updated' => $medicamentIsUpdated]],
            $medicamentIsUpdated ? 200 : 500
        );
    }
}