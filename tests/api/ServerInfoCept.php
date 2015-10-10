<?php 
$I = new ApiTester($scenario);
$I->wantTo('lookup server information from the API');

$I->sendGET('info/server-time');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('time');