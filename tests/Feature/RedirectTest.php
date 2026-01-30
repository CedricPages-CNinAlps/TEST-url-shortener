<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ShortUrl;

class RedirectTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_redirects_to_original_url(): void
    {
        $short = ShortUrl::factory()->create([
            'original_url' => 'https://exemple.com',
            'code' => 123456,
        ]);

        $response = $this->get('/r/123456');

        $response->assertRedirect('https://exemple.com');
        $this->assertDatabaseHas('short_urls',[
            'id' => $short->id,
        ]);
    }

    public function test_returns_404_when_not_found(): void
    {
        $this->get('/r/UNKNOWN')->assertStatus(404);
    }

    public function test_deleted_link_shows_deleted_page(): void
    {
        $short = ShortUrl::factory()->create([
            'original_url' => 'https://exemple.com',
            'code' => 123456,
        ]);

        $short->delete();
        $this->get('/r/123456')->assertStatus(410);
    }
}
