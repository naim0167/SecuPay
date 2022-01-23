<?php

namespace Tests\Feature;

use Tests\TestCase;

class DisableFlagBitsTest extends TestCase
{

    /**
     * Test Disable Flag Bits with master Key.
     *
     * @return void
     */
    public function test_disableFlagBitsTestWithMasterKey(): void
    {
        $flagBitId = 3;
        $transactionId = 4;

        $response = $this->withHeaders(['X-Header' => 'Value'])
            ->post('/api/disable_flagBit',
                ['trans_id' => $transactionId, 'flagbit_id' => $flagBitId],
                ['x-api-key' => '8067562d7138d72501485941246cf9b229c3a46a']
            );
        $response->assertSee(["FlagBit removed Successfully!"]);
        $response->assertStatus(200);
    }

    /**
     * Test Disable Flag Bits without master Key.
     *
     * @return void
     */
    public function test_disableFlagBitsTestWithOutMasterKey(): void
    {
        $flagBitId = 3;
        $transactionId = 4;

        $response = $this->withHeaders(['X-Header' => 'Value'])
            ->post('/api/disable_flagBit',
                ['trans_id' => $transactionId, 'flagbit_id' => $flagBitId],
                ['x-api-key' => '3ae7824c75f1aef362dab353bfceee6722c1f6f9']
            );
        $response->assertSee(["MasterKey not assigned!"]);
        $response->assertStatus(401);
    }
}
