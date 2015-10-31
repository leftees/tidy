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

    
}
