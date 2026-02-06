<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * Factory for generating ShortUrl instances.
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShortUrl>
 */
class ShortUrlFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShortUrl::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'code' => $this->generateAlphanumericCode(),
            'original_url' => $this->faker->url(),
            'clicks' => $this->faker->numberBetween(0, 1000),
            'last_used_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    /**
     * Generate a 6-character alphanumeric code.
     */
    private function generateAlphanumericCode(): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomCode = '';
        
        for ($i = 0; $i < 6; $i++) {
            $randomCode .= $characters[random_int(0, $charactersLength - 1)];
        }
        
        return $randomCode;
    }

    /**
     * Create a ShortUrl that has never been used.
     */
    public function neverUsed(): static
    {
        return $this->state(fn (array $attributes) => [
            'clicks' => 0,
            'last_used_at' => null,
        ]);
    }

    /**
     * Create a ShortUrl used recently.
     */
    public function recentlyUsed(): static
    {
        return $this->state(fn (array $attributes) => [
            'clicks' => $this->faker->numberBetween(50, 500),
            'last_used_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
        ]);
    }

    /**
     * Create a ShortUrl used long ago.
     */
    public function oldUsage(): static
    {
        return $this->state(fn (array $attributes) => [
            'clicks' => $this->faker->numberBetween(100, 1000),
            'last_used_at' => $this->faker->dateTimeBetween('-6 months', '-3 months'),
        ]);
    }

    /**
     * Create a ShortUrl with high traffic.
     */
    public function highTraffic(): static
    {
        return $this->state(fn (array $attributes) => [
            'clicks' => $this->faker->numberBetween(500, 2000),
            'last_used_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ]);
    }
}
