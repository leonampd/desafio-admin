<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */

namespace Leonam\Memed\Provider;

use Leonam\Memed\Repository\Medicament;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Leonam\Memed\Resource\Medicaments\Create as CreateMedicament;
use Leonam\Memed\Resource\Medicaments\Retrieve as RetrieveMedicament;
use Leonam\Memed\Resource\Medicaments\Update as UpdateMedicament;
use Leonam\Memed\Resource\Medicaments\RetrieveHistoric as RetrieveHistoricMedicament;
use Leonam\Memed\Repository\Medicament as MedicamentRepository;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MedicamentRoute implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $repository = new MedicamentRepository($container['db']);

        $container->get('/medicaments', new RetrieveMedicament($repository));
        $container->post('/medicaments', new CreateMedicament($repository));

        $container->get('/medicaments/{slug}/historic', function ($slug) use ($repository) {
            $retrieve = new RetrieveHistoricMedicament($repository);
            $retrieve->setMedicamentSlug($slug);
            return $retrieve();
        });

        $container->put('/medicaments/{slug}', function (Request $request, $slug) use ($repository) {
            $update = new UpdateMedicament($repository);
            $update->setMedicamentSlug($slug);

            return $update($request);
        });

        return $container;
    }
}
