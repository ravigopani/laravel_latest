<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'custom_primary_id' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->name(),
            'logo' => $this->faker->logo(),
            'details' => $this->faker->details(),
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
