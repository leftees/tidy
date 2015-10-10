<?php 
$I = new ApiTester($scenario);

$I->am('a guest user');
$I->wantTo('authenticate to the system');

