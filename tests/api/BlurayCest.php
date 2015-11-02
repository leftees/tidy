<?php

use Step\Api\Auth;
use Tidy\Bluray;

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
        $bluray = Bluray::create($original);
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
    
    public function testDestroyBluray(Auth $I)
    {
        $I->wantTo('destroy a stored bluray');
        
        $original = [
            'title' => 'Dead Man\'s Chest',
            'description' => 'Oh yeah',
            'account_id' => 2
        ];
        
        $bluray = Bluray::create($original);
        $I->laravel5()->seeRecord('blurays', $original);
        
        // Call the delete
        $I->sendDELETE('bluray/' . $bluray->id);
        
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['deleted' => true]);

        $I->laravel5()->dontSeeRecord('blurays', $original);
    }
    
    public function testListBlurays(Auth $I)
    {
        $I->wantTo('Load a list of blurays');
        
        // Add two of our items
        $bluray1 = ['title' => 'BR 1', 'account_id' => 3];
        $bluray2 = ['title' => 'BR 2', 'account_id' => 3];
        
        Bluray::create($bluray1);
        Bluray::create($bluray2);
        
        $I->sendGET('bluray', []);
        
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['count' => 2]);
        $I->seeResponseContainsJson($bluray1);
        $I->seeResponseContainsJson($bluray2);
    }
    
    public function testShowBluray(Auth $I)
    {
        $I->wantTo('Load a single bluray');

        $raw = ['title' => 'Bluray Name', 'account_id' => 3];
        $bluray = Bluray::create($raw);
        
        $I->sendGET('bluray/' . $bluray->id);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($raw);
    }
}
