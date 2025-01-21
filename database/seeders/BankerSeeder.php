<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BankerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bankers = [
            'Steve Jobs',
            'Bill Gates',
            'Mark Zuckerberg',
            'Elon Musk',

        ];

        foreach ($bankers as $banker) {
            User::create([
                'name' => $banker,
                'email' =>strtolower(explode(' ', $banker) [0]) . '@gmail.com',
                'role' => 'banker',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
