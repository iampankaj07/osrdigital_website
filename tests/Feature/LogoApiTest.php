<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoApiTest extends TestCase
{
    /**
     * Test that logo API endpoints return valid URLs
     *
     * @return void
     */
    public function test_logo_api_returns_valid_urls()
    {
        $response = $this->get('/api/logo/seeklogo');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'url'
                ]);

        $data = $response->json();
        $this->assertTrue($data['success']);
        $this->assertNotNull($data['url']);
        $this->assertStringContainsString('http', $data['url']);
    }

    /**
     * Test different logo types
     *
     * @return void
     */
    public function test_different_logo_types()
    {
        $types = ['default', 'light', 'dark', 'footer', 'admin', 'mobile'];

        foreach ($types as $type) {
            $response = $this->get("/api/logo/{$type}");

            $response->assertStatus(200);
            $data = $response->json();

            $this->assertTrue($data['success'], "Logo type '{$type}' should return success");
            $this->assertNotNull($data['url'], "Logo type '{$type}' should return a URL");
        }
    }
}
