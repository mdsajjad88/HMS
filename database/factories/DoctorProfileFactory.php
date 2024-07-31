<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorProfile>
 */
class DoctorProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'mobile' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'bmdc_number' => $this->faker->unique()->word,
            'blood_group' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
            'date_of_birth' => $this->faker->date,
            'nid' => $this->faker->unique()->numberBetween(100000000000, 999999999999),
            'specialist' => $this->faker->word,
            'fee' => $this->faker->numberBetween(100, 1000),
            'designation' => $this->faker->word,
            'consultant_type' => $this->faker->word,
            'address' => $this->faker->address,
            'description' => $this->faker->paragraph,
        ];
    }
}
