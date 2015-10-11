<?php 
$I = new ApiTester($scenario);

$I->am('a guest user');
$I->wantTo('login with invalid credentials');

$I->sendPOST('authenticate', ['email' => 'nada', 'password' => 'nope']);
$I->seeResponseCodeIs(401);
$I->seeResponseContainsJson(['error' => 'invalid_credentials']);

$I->wantTo('login with valid credentials');

