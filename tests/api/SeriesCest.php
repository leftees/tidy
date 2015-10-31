<?php

class SeriesCest
{
    protected $token;

    public function _before(ApiTester $I)
    {
        $I->refreshDb();
        $I->laravel5()->amOnPage('/');
        $I->getWebToken(true);
    }

    public function _after(ApiTester $I)
    {
    }

    public function testCreateSeries(ApiTester $I)
    {
        $I->am('a user');
        $I->wantTo('create a series through the API');

        $I->makeApiCall(
            'POST',
            '/api/series',
            [
                'title'      => 'Sample Test',
                'account_id' => 2,
            ]
        );

        $I->laravel5()->seeResponseCodeIs(200);
        $I->laravel5()->seeRecord('series', ['title' => 'Sample Test']);
    }

    public function testSeriesValidationFails(ApiTester $I)
    {
        $I->wantTo('get an error');
        
        $badSeries = [
            'title'      => '',
            'account_id' => 2,
        ];

        $I->makeApiCall('POST', '/api/series', $badSeries);

        $I->laravel5()->seeResponseCodeIs(422);
        $I->laravel5()->see('The title field is required');
    }
    
    public function testShowSeries(ApiTester $I)
    {
        $I->wantTo('show a stored series');
        
        // Populate a series
        $series = \Tidy\Series::create(['title' => 'Pegasus Falls', 'account_id' => 3]);
        
        $I->makeApiCall('GET', '/api/series/' . $series->id, []);
        
        $I->laravel5()->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->laravel5()->see('series');
        $I->laravel5()->see('"id":"1"');
        
    }
        

    public function testDestroySeries(ApiTester $I)
    {
        $I->am('a user');
        $I->wantTo('destroy a stored series');

        // Populate a series
        $series = \Tidy\Series::create(['title' => 'Pegasus 2 Falls', 'account_id' => 3]);
        $I->laravel5()->seeRecord('series', ['title' => 'Pegasus 2 Falls']);
        
        $I->makeApiCall('DELETE', '/api/series/' . $series->id, []);

        $I->laravel5()->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->laravel5()->see('"deleted"');
        
        $I->laravel5()->dontSeeRecord('series', ['id' => $series->id]);
    }


    public function testUpdateSeries(ApiTester $I)
    {
        $I->am('a user');
        $I->wantTo('update a stored series');

        // Populate a series
        $originalName = 'Toon World';
        $newName = 'Failed Toon World';
        
        $series = \Tidy\Series::create(['title' => $originalName, 'account_id' => 3]);
        $I->laravel5()->seeRecord('series', ['title' => $originalName]);
        $I->laravel5()->dontSeeRecord('series', ['title' => $newName]);

        $I->makeApiCall('PUT', '/api/series/' . $series->id, ['title' => $newName, 'account_id' => 3]);
        
        $I->laravel5()->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->laravel5()->seeRecord('series', ['id' => $series->id, 'title' => $newName]);
        $I->laravel5()->dontSeeRecord('series', ['id' => $series->id, 'title' => $originalName]);
        
    }
    
}
