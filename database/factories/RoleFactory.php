<?php

namespace Database\Factories;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,

        ];
    }

    public function configure(): RoleFactory|Factory
    {
        return $this->afterCreating(function (Role $role) {
            $permissions = Permission::inRandomOrder()->limit(random_int(1, 3))->get();
            $role->permissions()->attach($permissions);
        });
    }
}
