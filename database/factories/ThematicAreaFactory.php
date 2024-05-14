<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ThematicArea>
 */
class ThematicAreaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'description' => fake('pt_BR')->text(150),
        ];
    }
}
