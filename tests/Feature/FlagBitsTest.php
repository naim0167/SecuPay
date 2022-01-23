<?php

namespace Tests\Feature;

use Tests\TestCase;

class FlagBitsTest extends TestCase
{
    /**
     * Test getting all FlagBits.
     *
     * @return void
     */
    public function test_flagBitsTest()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value'
        ])->get('/api/flagbits', ['x-api-key' => '3ae7824c75f1aef362dab353bfceee6722c1f6f9']);
        $response->assertJson(['Data Flag' => []]);
        $response->assertStatus(200);
    }
}
