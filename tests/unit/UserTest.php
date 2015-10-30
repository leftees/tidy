<?php

use Codeception\Module\Laravel5;
use Mockery as M;
use Tidy\User;

class UserTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testUserCanBeCreated()
    {
        $attributes = [
            'email' => 'test55@example.com',
            'name' => 'Test Name',
            'password' => bcrypt('test')
        ];
        $user = User::create($attributes);
        
        $this->laravel()->seeRecord('users', $attributes);
        
        $this->assertGreaterThan(0, $user->id);
    }

    /**
     * @return Laravel5
     */
    protected function laravel()
    {
        return $this->getModule('Laravel5');
    }

    /**
     * @return \Illuminate\Foundation\Application
     */
    protected function app()
    {
        return $this->laravel()->getApplication();
    }
    

    protected function _before()
    {
    }

    protected function _after()
    {
        M::close();
    }
}