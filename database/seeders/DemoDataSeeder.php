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
        // Create a demo user
        $demoUser = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => Hash::make('0123456789'),
        ]);

        // Create demo URLs with specific codes
        $demoUrls = [
            [
                'code' => '111111',
                'original_url' => 'https://www.laravel.com/docs',
                'description' => 'Laravel documentation',
                'clicks' => 245,
                'last_used_at' => now()->subDays(1),
            ],
            [
                'code' => '222222',
                'original_url' => 'https://github.com/laravel/laravel',
                'description' => 'Laravel GitHub repository',
                'clicks' => 89,
                'last_used_at' => now()->subWeeks(2),
            ],
            [
                'code' => '333333',
                'original_url' => 'https://www.php.net',
                'description' => 'Official PHP website',
                'clicks' => 0,
                'last_used_at' => null,
            ],
            [
                'code' => '444444',
                'original_url' => 'https://getbootstrap.com',
                'description' => 'Bootstrap documentation',
                'clicks' => 156,
                'last_used_at' => now()->subDays(3),
            ],
            [
                'code' => '555555',
                'original_url' => 'https://developer.mozilla.org',
                'description' => 'MDN Web Docs',
                'clicks' => 412,
                'last_used_at' => now()->subHours(6),
            ]
        ];

        foreach ($demoUrls as $urlData) {
            ShortUrl::factory()->create([
                'user_id' => $demoUser->id,
                'code' => $urlData['code'],
                'original_url' => $urlData['original_url'],
                'description' => $urlData['description'],
                'clicks' => $urlData['clicks'],
                'last_used_at' => $urlData['last_used_at'],
            ]);
        }

        $this->command->info('Demo data created successfully!');
        $this->command->info('Demo user: demo@example.com');
        $this->command->info('Demo URLs with codes: 111111, 222222, 333333, 444444, 555555');
    }
}
