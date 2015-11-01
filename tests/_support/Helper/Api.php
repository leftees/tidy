<?php
namespace Helper;

class Api extends \Codeception\Module
{
    
    protected $laravel;

    /**
     * Will reset the test database
     */
    public function refreshDb()
    {
        \Artisan::call('migrate:refresh', ['--seed' => true]);
    }

    /**
     * @return \Codeception\Module\Laravel5
     * @throws \Codeception\Exception\ModuleException
     */
    public function laravel5()
    {
        if(!$this->laravel) {
            $this->laravel = $this->getModule('Laravel5');
        }
        
        return $this->laravel;
    }

}
