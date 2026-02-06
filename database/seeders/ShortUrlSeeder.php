<?php

namespace Database\Seeders;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * @extends \Illuminate\Database\Seeder<App\Models\ShortUrl>
 */
class ShortUrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer des URLs raccourcies pour chaque utilisateur
        $users = User::all();

        foreach ($users as $user) {
            // Créer 5-20 URLs par utilisateur avec différents scénarios
            ShortUrl::factory()
                ->count(rand(3, 8))
                ->create(['user_id' => $user->id]);

            // Quelques URLs jamais utilisées
            ShortUrl::factory()
                ->neverUsed()
                ->count(rand(1, 3))
                ->create(['user_id' => $user->id]);

            // Quelques URLs récemment utilisées
            ShortUrl::factory()
                ->recentlyUsed()
                ->count(rand(1, 3))
                ->create(['user_id' => $user->id]);

            // Quelques URLs avec fort trafic
            ShortUrl::factory()
                ->highTraffic()
                ->count(rand(0, 2))
                ->create(['user_id' => $user->id]);
        }

        // Créer quelques URLs spécifiques pour les tests
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
