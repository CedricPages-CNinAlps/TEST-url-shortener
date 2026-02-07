<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ShortUrl;
use App\Models\User;

class ShortUrlPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_edit_own_short_url(): void
    {
        $user = User::factory()->create();
        $shortUrl = ShortUrl::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->get("/shorturls/{$shortUrl->id}/edit");

        $response->assertStatus(200);
    }

    public function test_user_cannot_edit_others_short_url(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $shortUrl = ShortUrl::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)
            ->get("/shorturls/{$shortUrl->id}/edit");

        $response->assertStatus(403);
    }

    public function test_user_can_update_own_short_url(): void
    {
        $user = User::factory()->create();
        $shortUrl = ShortUrl::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->put("/shorturls/{$shortUrl->id}", [
                'original_url' => 'https://www.updated-url.com'
            ]);

        $response->assertRedirect('/shorturls');
    }

    public function test_user_cannot_update_others_short_url(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $shortUrl = ShortUrl::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)
            ->put("/shorturls/{$shortUrl->id}", [
                'original_url' => 'https://www.updated-url.com'
            ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_short_url(): void
    {
        $user = User::factory()->create();
        $shortUrl = ShortUrl::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->delete("/shorturls/{$shortUrl->id}");

        $response->assertRedirect('/shorturls');
    }

    public function test_user_cannot_delete_others_short_url(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $shortUrl = ShortUrl::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)
            ->delete("/shorturls/{$shortUrl->id}");

        $response->assertStatus(403);
    }
}
