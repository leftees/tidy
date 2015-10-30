<?php


use Mockery as M;

class BlurayTest extends \Codeception\TestCase\Test
{
    /**
     * @var \ApiTester
     */
    protected $tester;
    
    protected $token;

    protected function _before()
    {
        $this->tester->refreshDb();
        $this->tester->laravel5()->amOnPage('/');
        $this->token = $this->tester->getWebToken();
    }

    // tests

    protected function _after()
    {
        M::close();
    }
    
    public function testCreateBluray()
    {
        $I = $this->tester;
        $I->wantTo('create a bluray through the API');
        
        $I->makeApiCall($this->token, 'POST', '/api/bluray', [
            'title' => 'Test Bluray',
            'description' => 'Description',
            'account_id' => 2
        ]);
        
        $I->laravel5()->seeRecord('blurays', ['title' => 'Test Bluray']);
    }
    
}