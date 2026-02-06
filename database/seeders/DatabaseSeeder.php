<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * This class is responsible for seeding the application's database.
 *
 * It uses the `WithoutModelEvents` trait to prevent model events from being executed.
 *
 * It includes two seeders: `UserSeeder` and `ShortUrlSeeder`.
 *
 * The `UserSeeder` is responsible for creating a user with a random name and email.
 * The `ShortUrlSeeder` is responsible for creating a short URL with a random URL and title.
 *
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * This method calls the `run` method of the `UserSeeder` and `ShortUrlSeeder` classes.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ShortUrlSeeder::class,
        ]);
    }
}
