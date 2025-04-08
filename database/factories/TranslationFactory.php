<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => 'key_' . Str::uuid(),
            // 'key' => $this->faker->unique()->word(),
            'locale' => $this->faker->randomElement(['en', 'fr', 'es']),
            'value' => $this->faker->sentence(),
        ];
    }
}
