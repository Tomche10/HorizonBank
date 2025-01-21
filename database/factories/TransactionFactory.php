<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Get a random account from the database
        $senderAccount = User::inRandomOrder()->where('role', 'user')->first();
        $receiverAccount = User::inRandomOrder()->where('role', 'user')->first();

        return [
            'sender_id' => $senderAccount->id, // Link to a sender account
            'receiver_id' => $receiverAccount->id, // Link to a receiver account
            'amount' => $this->faker->randomFloat(2, 100, 5000), // Random transaction amount
            'transaction_type' => $this->faker->randomElement(['deposit', 'withdrawal', 'transfer']),
            'status' => $this->faker->randomElement(['completed', 'pending']),
        ];
    }
}
