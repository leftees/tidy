<?php

use \Mockery as M;

class AccountTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
        M::close();
    }

    // tests
    public function testMe()
    {

    }
}