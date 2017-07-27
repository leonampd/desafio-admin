<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */
require 'vendor/autoload.php';

use Silex\Application;
use JDesrosiers\Silex\Provider\CorsServiceProvider;
use Leonam\Memed\Provider\MedicamentRoute;

$application = new Application();
$application['debug'] = true;

// service providers
// cors
$application->register(new CorsServiceProvider(), ["cors.allowOrigin" => "http://desafio-memed.dev"]);
$application['cors-enabled']($application);

//doctrine
$application->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/memed.db',
    ),
));

// rotas
$application->register(new MedicamentRoute());

$application->run();
