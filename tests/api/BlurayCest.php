<?php

class BlurayCest
{
    public function _before(\Step\Api\Auth $I)
    {
        $I->refreshDb();
        $I->authenticateUser();
        $I->addTokenToHttpHeader();
    }

    public function _after(ApiTester $I)
    {
    }

    public function testCreateBluray(\Step\Api\Auth $I)
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
}
