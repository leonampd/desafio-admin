<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Provider;


use Symfony\Component\HttpFoundation\Request;

interface BaseRoute
{
    public function __invoke(Request $request = null);
}