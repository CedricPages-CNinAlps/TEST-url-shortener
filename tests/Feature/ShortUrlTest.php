<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ShortUrl;
use App\Models\User;


class ShortUrlTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_guest_cannot_access_dashboard(): void
    {
        $this->get('/dashboard')
        ->assertRedirect('/login');;
    }

    public function test_user_can_create_short_url(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/shorturls', [
                'original_url' => 'https://www.exemple.com'
            ]);

        $response->assertRedirect('/shorturls');
        $this->assertDatabaseCount('short_urls',1);
        $this->assertDatabaseHas('short_urls',[
            'user_id' => $user->id,
            'original_url' => 'https://www.exemple.com'
        ]);
    }

    public function test_user_can_sees_only_own_links(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        ShortUrl::factory()->create(['user_id' => $user1->id]);
        ShortUrl::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)
            ->post('/shorturls');

        $response->assertStatus(200);
        $this->assertEquals(1,$response->viewData('shortUrls')->count());
    }
}
