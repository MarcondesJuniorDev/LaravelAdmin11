<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::factory(20)->create();
        Role::factory(10)->create();
        User::factory(100)->create();
        UserDetail::factory(100)->create();

        User::factory()->create([
            'name' => 'Super',
            'email' => 'super@super.com',
            'password' => bcrypt('M4rc0nd35'),
        ]);

        Department::factory(50)->create();
    }
}
