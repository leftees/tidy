<?php

use Step\Api\Auth;

class BlurayCest
{
    public function _before(Auth $I)
    {
        $I->refreshDb();
        $I->authenticateUser();
        $I->addTokenToHttpHeader();
    }

    public function _after(Auth $I)
    {
    }

    public function testCreateBluray(Auth $I)
    {
        $I->wantTo('create a bluray through the API');

        $bluray = [
            'title'       => 'Test Bluray',
            'description' => 'Description',
            'account_id'  => 2,
        ];
        
        $I->sendPOST('bluray', $bluray);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($bluray);

        $I->laravel5()->seeRecord('blurays', $bluray);
    }

    public function testUpdateBluray(Auth $I)
    {
        $I->wantTo('update a stored bluray');

        $original = [
            'title'       => 'Archer Vice',
            'description' => 'Description',
            'account_id'  => 2,
        ];

        $updated = [
            'title'       => 'The Muppets',
            'description' => 'Go to Rome'
        ];

        // Create the series first of all
        $bluray = \Tidy\Bluray::create($original);
        $I->laravel5()->seeRecord('blurays', $original);
        $I->laravel5()->dontSeeRecord('blurays', $updated);

        // Run the update
        $I->sendPUT('bluray/' . $bluray->id, $updated);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($updated);

        $I->laravel5()->seeRecord('blurays', $updated);
        $I->laravel5()->dontSeeRecord('blurays', $original);
    }
}
