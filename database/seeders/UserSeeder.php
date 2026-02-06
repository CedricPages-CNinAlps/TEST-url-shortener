<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserSeeder
 *
 * Seeder for creating test users.
 *
 * This class is responsible for seeding the database with test users. It creates a default test user with a specific password and multiple additional users for testing purposes. It also creates a specific admin user.
 *
 * @package Database\Seeders
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the default test user with a specific password
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('0123456789'),
        ]);

        // Create additional users for testing
        User::factory()->count(5)->create();

        // Create a specific admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('0123456789'),
        ]);
    }
}
