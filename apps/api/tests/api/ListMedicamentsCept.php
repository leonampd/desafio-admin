<?php
use \Codeception\Util\HttpCode;
$I = new ApiTester($scenario);
$I->wantTo('List all the medicaments');
$I->sendGET('/medicaments');
$I->seeResponseCodeIs(HttpCode::OK); // 200
$I->seeResponseIsJson();
$I->seeResponseMatchesJsonType([
    'data' => [
        [
            'slug' => 'string',
            'ggrem' => 'string',
            'nome' => 'string',
        ]
    ]
]);
