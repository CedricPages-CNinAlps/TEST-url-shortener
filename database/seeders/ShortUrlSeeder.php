<?php

namespace Database\Seeders;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * This class is responsible for seeding the database with short URLs.
 * It creates short URLs for each user, with different scenarios.
 * It also creates specific URLs for testing purposes.
 */
class ShortUrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create short URLs for each user
        $users = User::all();

        foreach ($users as $user) {
            // Create 5-20 URLs per user with different scenarios
            ShortUrl::factory()
                ->count(rand(3, 8))
                ->create(['user_id' => $user->id]);

            // Some URLs never used
            ShortUrl::factory()
                ->neverUsed()
                ->count(rand(1, 3))
                ->create(['user_id' => $user->id]);

            // Some URLs recently used
            ShortUrl::factory()
                ->recentlyUsed()
                ->count(rand(1, 3))
                ->create(['user_id' => $user->id]);

            // Some URLs with high traffic
            ShortUrl::factory()
                ->highTraffic()
                ->count(rand(0, 2))
                ->create(['user_id' => $user->id]);
        }

        // Create specific URLs for testing
        $testUser = User::where('email', 'test@example.com')->first();

        if ($testUser) {
            ShortUrl::factory()->create([
                'user_id' => $testUser->id,
                'code' => '123456',
                'original_url' => 'https://www.google.com',
                'clicks' => 150,
                'last_used_at' => now()->subDays(2),
            ]);

            ShortUrl::factory()->create([
                'user_id' => $testUser->id,
                'code' => '789012',
                'original_url' => 'https://www.github.com',
                'clicks' => 0,
                'last_used_at' => null,
            ]);

            ShortUrl::factory()->create([
                'user_id' => $testUser->id,
                'code' => '345678',
                'original_url' => 'https://www.laravel.com',
                'clicks' => 89,
                'last_used_at' => now()->subMonths(3),
            ]);
        }
    }
}
