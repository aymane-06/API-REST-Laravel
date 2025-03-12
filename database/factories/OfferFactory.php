<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->text(),
            'location' => fake()->city() . ', ' . fake()->country(),
            'company_name' => fake()->company(),
            'salary' => fake()->optional(0.8)->randomFloat(2, 30000, 150000),
            'job_type' => fake()->randomElement(['full-time', 'part-time', 'contract', 'freelance', 'internship']),
            'experience_level' => fake()->randomElement(['entry', 'junior', 'mid', 'senior', 'executive']),
            'skills' => json_encode(fake()->randomElements(['PHP', 'JavaScript', 'Laravel', 'Vue.js', 'React', 'MySQL', 'Docker', 'AWS', 'DevOps', 'Python'], rand(3, 6))),
            'application_deadline' => fake()->dateTimeBetween('now', '+30 days'),
            'is_active' => fake()->boolean(80),
            'user_id' => '1',
            ];
    }
}
