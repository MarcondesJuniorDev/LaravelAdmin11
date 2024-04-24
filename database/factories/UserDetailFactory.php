<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDetail>
 */
class UserDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'image' => $this->faker->imageUrl(),
            'about' => $this->faker->paragraph(),
            'featured_homepage' => $this->faker->randomElement(['yes', 'no']),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'website' => $this->faker->url(),
            'lattes' => $this->faker->url(),
            'facebook' => $this->faker->url(),
            'twitter' => $this->faker->url(),
            'instagram' => $this->faker->url(),
            'linkedin' => $this->faker->url(),
            'github' => $this->faker->url(),
        ];
    }
}
