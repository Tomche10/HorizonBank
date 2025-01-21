<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Get an existing user from the database (ensuring one account per user)
        $user = User::inRandomOrder()->where('role', 'user')->first();

        return [
            'user_id' => $user->id, // Link to the existing user
            'account_number' => $this->faker->unique()->numerify('ACCT-#####'), // Random account number
            'balance' => $this->faker->randomFloat(2, 1000, 10000), // Random balance
        ];
    }
}
