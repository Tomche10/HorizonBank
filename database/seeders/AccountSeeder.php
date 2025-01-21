<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();
        $users = User::where('role', 'user')->get();
        foreach ($users as $user) {

            Account::create([
            'user_id'=> $user->id, // Link to the existing user
            'account_number' => $fake->unique()->numerify('ACCT-#####'), // Random account number
            'balance' => $fake->randomFloat(2, 1000, 10000), // Random balance
            ]);
        }
    }
}
