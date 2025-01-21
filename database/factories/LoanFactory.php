<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Get an existing user from the database
        $user = User::inRandomOrder()->where('role', 'user')->first();

        return [
            'user_id' => $user->id, // Link to an existing user
            'loan_amount' => $this->faker->randomFloat(2, 1000, 100000), // Random loan amount
            'interest_rate' => $this->faker->randomFloat(2, 5, 15), // Random interest rate between 5% to 15%
            'repayment_period' => $this->faker->numberBetween(12, 60), // Random repayment period between 12 and 60 months
            'monthly_installment' => $this->faker->randomFloat(2, 100, 2000), // Random monthly installment
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }

}
