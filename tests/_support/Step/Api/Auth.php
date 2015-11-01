<?php
namespace Step\Api;

class Auth extends \ApiTester
{
    protected $token;

    public function authenticateUser(array $user = null)
    {
        $I = $this;
        
        if(!$user) {
            $user = [
                'email' => 'test1@example.com',
                'password' => 'qwerty'
            ];
        }
        
        $I->wantTo('Authenticate with the API and get a token');

        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->sendPOST('authenticate', $user);

        $I->canSeeResponseIsJson();
        $I->cantSeeResponseContains('error');
        $I->canSeeResponseContains('token');
        
        $I->wantTo('Parse the web token');

        $response = json_decode($I->grabResponse(), true);

        $token = !empty($response['token']) ? $response['token'] : '';

        if(empty($token)) {
            throw new \Exception('No auth token could be loaded');
        }
        
        $this->token = $token;
    }
    
    public function addTokenToHttpHeader($token = null)
    {
        if(!$token) {
            $token = $this->token;
        }
        
        $I = $this;

        $I->haveHttpHeader('Authorization', 'Bearer ' . $token);
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        
    }

    public function getToken()
    {
        if(!$this->token) {
            throw new \Exception('Must call authenticateUser first');
        }
        
        return $this->token;
    }

}