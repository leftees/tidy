<?php 
$I = new AcceptanceTester($scenario);

$I->am('general public');
$I->wantTo('see the public home page');

$I->amOnPage('/');
$I->see('You\'ve reached the end zone.');