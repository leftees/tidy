<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Tidy\User::create(['name' => 'Test User', 'email' => 'test1@example.com', 'password' => bcrypt('qwerty')]);
        factory(Tidy\User::class, 5)->create()->each(function($u) {
            
        });
    }
}
