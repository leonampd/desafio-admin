<?php
/**
 * @author LeonamDias <leonam.pd@gmail.com>
 * @package PHP
 */
use \Codeception\Util\HttpCode;
$I = new ApiTester($scenario);
$I->wantTo('Create a new medicament');
$I->sendPOST('/medicaments',['nome' => 'Nimesulida', 'ggrem' => '8279349']);
$I->seeResponseCodeIs(HttpCode::CREATED); // 201
$I->seeResponseIsJson();