<?php

namespace Tests\Feature;

use Tests\TestCase;

class SecureTest extends TestCase
{
    /**
     * Test api key is authenticated
     *
     * @return void
     */
    public function test_authenticatedApiKey(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->get('/api/secure', ['x-api-key' => '3ae7824c75f1aef362dab353bfceee6722c1f6f9']);

        $response->assertStatus(200);
    }

    /**
     * Test Api key is not authenticated.
     *
     * @return void
     */
    public function test_authenticationdWithWrongApiKey(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value'
        ])->get('/api/secure', ['x-api-key' => 'test']);

        $response->assertStatus(401);
    }
}
