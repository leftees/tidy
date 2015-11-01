<?php

use Step\Api\Auth;

class SeriesCest
{
    public function _before(Auth $I)
    {
        $I->refreshDb();
        $I->authenticateUser();
        $I->addTokenToHttpHeader();
    }

    public function testCreateSeries(Auth $I)
    {
        $I->wantTo('create a series through the API');

        $series = [
            'title'      => 'Sample Test',
            'account_id' => 2,
        ];
        $I->sendPOST('series', $series);
        
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($series);
        
        $I->laravel5()->seeRecord('series', $series);
    }

    public function testSeriesValidationFails(Auth $I)
    {
        $I->wantTo('get an error');
        
        $badSeries = [
            'title'      => '',
            'account_id' => 2,
        ];

        $I->sendPOST('series', $badSeries);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(422);
        $I->seeResponseContainsJson(['title' => ['The title field is required.']]);
    }
    
    public function testShowSeries(Auth $I)
    {
        $I->wantTo('show a stored series');
        
        // Populate a series
        $rawSeries = ['title' => 'Pegasus Falls', 'account_id' => 3];
        $series = \Tidy\Series::create($rawSeries);
        
        $I->sendGET('series/' . $series->id);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($rawSeries);
    }
    
    public function testDestroySeries(Auth $I)
    {
        $I->wantTo('destroy a stored series');

        // Populate a series
        $rawSeries = ['title' => 'Pegasus 2 Falls', 'account_id' => 3];
        $series = \Tidy\Series::create($rawSeries);
        
        $I->laravel5()->seeRecord('series', $rawSeries);
        
        $I->sendDELETE('series/' . $series->id);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['deleted' => true]);
        
        
        $I->laravel5()->dontSeeRecord('series', $rawSeries);
    }

    public function testUpdateSeries(Auth $I)
    {
        $I->wantTo('update a stored series');

        $originalSeries = [
            'title' => 'Toon World',
            'account_id' => 3
        ];
        
        $updatedSeries = [
            'title' => 'Lumos Maxima',
            'account_id' => 3
        ];
        
        // Create the series first of all
        $series = \Tidy\Series::create($originalSeries);
        $I->laravel5()->seeRecord('series', $originalSeries);
        $I->laravel5()->dontSeeRecord('series', $updatedSeries);
        
        // Run the update
        $I->sendPUT('series/' . $series->id, $updatedSeries);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($updatedSeries);

        $I->laravel5()->seeRecord('series', $updatedSeries);
        $I->laravel5()->dontSeeRecord('series', $originalSeries);
    }
    
}
