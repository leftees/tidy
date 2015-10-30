<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Tidy\User;

class Api extends \Codeception\Module
{
    /**
     * @param $token
     * @param $method
     * @param $uri
     * @param array $params
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function makeApiCall($token, $method, $uri, array $params) {
        return $this->laravel5()->client->request($method, $uri, $params, [], [
            'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $token,
            'HTTP_ACCEPT' => 'appliction/json'
        ], null, true);
    }
    
    public function refreshDb()
    {
        \Artisan::call('migrate:refresh', ['--seed' => true]);
    }
    
    public function getWebToken()
    {
        $testUser = [
            'email' => 'test1@example.com',
            'password' => 'qwerty'
        ];
        
        $authData = $this->laravel5()->_request(
            'POST',
            '/api/authenticate',
            $testUser,
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        $auth = json_decode($authData, true);
        $token = isset($auth['token']) ? $auth['token'] : null;

        $this->assertNotEmpty($token, 'Token was not generated');

        return $token;
    }

    /**
     * @return \Codeception\Module\Laravel5
     * @throws \Codeception\Exception\ModuleException
     */
    public function laravel5()
    {
        /** @var \Codeception\Module\Laravel5 $laravel5 */
        $laravel5 = $this->getModule('Laravel5');

        return $laravel5;
    }

}
