<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'contact_name' => $this->faker->name,
            'contact_email' => $this->faker->email(),
            'contact_phone' => rand(100000,3000000),
            'contact_address' => $this->faker->name,
            'contact_published' => 1,
        ];
    }
}
