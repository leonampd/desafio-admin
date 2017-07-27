<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Resource\Medicaments;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use \Leonam\Memed\Repository\Medicament as MedicamentRepository;

interface Base
{
    /**
     * Base constructor.
     *
     * @param MedicamentRepository|null $repository
     */
    public function __construct(MedicamentRepository $repository = null);

    /**
     * @param \Symfony\Component\HttpFoundation\Request|null $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function __invoke(Request $request = null) : JsonResponse;
}