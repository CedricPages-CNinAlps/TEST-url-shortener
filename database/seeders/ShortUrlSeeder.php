<?php

namespace Database\Seeders;

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
            // Créer 5-20 URLs par utilisateur
            ShortUrl::factory()
                ->count(rand(5, 20))
                ->create(['user_id' => $user->id]);
        }

        // Créer quelques URLs spécifiques pour les tests
        $testUser = User::where('email', 'test@example.com')->first();

        if ($testUser) {
            ShortUrl::factory()->create([
                'user_id' => $testUser->id,
                'code' => '123456',
                'original_url' => 'https://www.google.com',
            ]);

            ShortUrl::factory()->create([
                'user_id' => $testUser->id,
                'code' => '789012',
                'original_url' => 'https://www.github.com',
            ]);

            ShortUrl::factory()->create([
                'user_id' => $testUser->id,
                'code' => '345678',
                'original_url' => 'https://www.laravel.com',
            ]);
        }
    }
}
