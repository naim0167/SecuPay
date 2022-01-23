<?php

namespace Tests\Feature;

use Tests\TestCase;

class FlagBitsHistoryTest extends TestCase
{
    /**
     * FlagBit History Test
     *
     * @return void
     */
    public function test_flagBitHistoryTest()
    {
        $transactionId = 4;

        $response = $this->withHeaders([
            'X-Header' => 'Value'
        ])->get('/api/flagBitHistory?trans_id=' . $transactionId, ['x-api-key' => '3ae7824c75f1aef362dab353bfceee6722c1f6f9']);
        $response->assertJson([[]]);
        $response->assertStatus(200);
    }
}
