<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Leonam\Memed\Resource\Medicaments\Create as CreateMedicament;

class MedicamentRoute implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container->get('/medicaments', new CreateMedicament());
        return $container;
    }
}