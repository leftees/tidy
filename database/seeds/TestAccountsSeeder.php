<?php

use Illuminate\Database\Seeder;

class TestAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $makeAccount = function() {
            return factory(\Tidy\Account::class, 1)->create();
        };

        $accounts = [
            $makeAccount(),
            $makeAccount(),
            $makeAccount(),
            $makeAccount(),
            $makeAccount(),
            $makeAccount(),
        ];
        
        $user = \Tidy\User::create(['name' => 'Test User', 'email' => 'test1@example.com', 'password' => bcrypt('qwerty')]);
        $user->accounts()->saveMany([$accounts[1], $accounts[2]]);
        
        factory(Tidy\User::class, 10)->create()->each(function($u) use ($accounts) {
            $accountIds = array_rand($accounts, rand(1, 6));
            if(!is_array($accountIds)){
                $accountIds = [$accountIds];
            }
            
            $accts = [];
            foreach($accountIds as $id) {
                $accts[] = $accounts[$id];
            }
            
            
            $u->accounts()->saveMany($accts);
        });
    }
}
