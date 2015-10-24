<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \Tidy\User::create(['name' => 'Test User', 'email' => 'test1@example.com', 'password' => bcrypt('qwerty')]);
        $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
