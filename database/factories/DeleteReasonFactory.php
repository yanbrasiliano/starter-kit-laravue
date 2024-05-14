<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeleteReasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'deleted_user_id' => User::factory(),
            'deleted_user_email' => $this->faker->email,
            'deleted_user_name' => $this->faker->name,
            'deleted_by_user_id' => User::factory(),
            'deleted_by_user_email' => $this->faker->email,
            'deleted_by_user_name' => $this->faker->name,
            'reason' => $this->faker->text(200),
            'deleted_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
