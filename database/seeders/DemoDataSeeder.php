<?php

namespace Database\Seeders;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder for creating demo data.
 */
class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur de démonstration
        $demoUser = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => Hash::make('0123456789'),
        ]);

        // Créer des URLs de démonstration avec des codes spécifiques
        $demoUrls = [
            [
                'code' => '111111',
                'original_url' => 'https://www.laravel.com/docs',
                'description' => 'Documentation Laravel'
            ],
            [
                'code' => '222222',
                'original_url' => 'https://github.com/laravel/laravel',
                'description' => 'Laravel sur GitHub'
            ],
            [
                'code' => '333333',
                'original_url' => 'https://www.php.net',
                'description' => 'Site officiel PHP'
            ],
            [
                'code' => '444444',
                'original_url' => 'https://getbootstrap.com',
                'description' => 'Documentation Bootstrap'
            ],
            [
                'code' => '555555',
                'original_url' => 'https://developer.mozilla.org',
                'description' => 'MDN Web Docs'
            ]
        ];

        foreach ($demoUrls as $urlData) {
            ShortUrl::factory()->create([
                'user_id' => $demoUser->id,
                'code' => $urlData['code'],
                'original_url' => $urlData['original_url'],
            ]);
        }

        $this->command->info('Demo data created successfully!');
        $this->command->info('Demo user: demo@example.com');
        $this->command->info('Demo URLs with codes: 111111, 222222, 333333, 444444, 555555');
    }
}
