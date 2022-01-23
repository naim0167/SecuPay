<?php

namespace Tests\Feature;

use Tests\TestCase;

class GetActiveFlagBitsTest extends TestCase
{
    /**
     * Test getting only active FlagBits
     *
     * @return void
     */
    public function test_getActiveFlagBitsName(): void
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->get('/api/getActiveFlagBits', ['x-api-key' => '3ae7824c75f1aef362dab353bfceee6722c1f6f9']);
        $response->assertJson(['Data Flag' => []]);
        $response->assertStatus(200);

    }

}
