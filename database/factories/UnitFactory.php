<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description' => fake('pt_BR')->text(150),
            'acronym' => fake('pt_BR')->text(50),
        ];
    }
}
