<?php
use \ApiTester;

class BlurayCest
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

    public function testCreateBluray(ApiTester $I)
    {
        $I->am('a user');
        $I->wantTo('create a bluray through the API');

        $I->makeApiCall('POST', '/api/bluray', [
            'title' => 'Test Bluray',
            'description' => 'Description',
            'account_id' => 2
        ]);

        $I->laravel5()->seeResponseCodeIs(200);
        $I->laravel5()->seeRecord('blurays', ['title' => 'Test Bluray']);
    }
}
