<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */
require 'vendor/autoload.php';

use Silex\Application;
use JDesrosiers\Silex\Provider\CorsServiceProvider;

$application = new Application();
$application['debug'] = true;

// service providers
// cors
$application->register(new CorsServiceProvider(), ["cors.allowOrigin" => "http://desafio-memed.dev"]);
$application['cors-enabled']($application);

// rotas
$application->run();
