<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserSeeder
 *
 * Seeder pour la création des utilisateurs de test.
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
        // Créer l'utilisateur de test avec mot de passe spécifique
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('0123456789'),
        ]);

        // Créer des utilisateurs supplémentaires pour les tests
        User::factory()->count(5)->create();

        // Créer un utilisateur admin spécifique
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('0123456789'),
        ]);
    }
}
