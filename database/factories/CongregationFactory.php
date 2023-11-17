<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VisibleCongregation>
 */
class CongregationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identifier' => Str::random(10),
            'congregation' => $this->faker->company(),
            'congregation_number' => $this->faker->unique()->numberBetween(1, 99999),
            'contact_firstname' => $this->faker->firstName(),
            'contact_lastname' => $this->faker->lastName(),
            'contact_email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
