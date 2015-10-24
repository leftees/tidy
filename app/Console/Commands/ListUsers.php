<?php

namespace Tidy\Console\Commands;

use Illuminate\Console\Command;
use Tidy\User;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists the active user accounts';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $headers = ['Name', 'Email'];

        $users = User::all(['name', 'email'])->toArray();

        $this->table($headers, $users);
    }
}
