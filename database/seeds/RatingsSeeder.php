<?php

use Illuminate\Database\Seeder;
use Tidy\Rating;

class RatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $r = [
            [
                'id'          => 1,
                'name'        => 'M',
                'description' => 'Suitable for Mature Audiences 16 Years and over',
                'for_dvd'     => true,
                'for_bluray'  => true,
            ],
        ];
        
        foreach ($r as $rating) {
            Rating::create($rating);
        }
    }
}
