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

        if(env('APP_ENV') !== 'production') {
            $this->call(UserTableSeeder::class);
        }
        
        // Prod level
        $this->call(RatingsSeeder::class);

        Model::reguard();
    }
}
