<?php

namespace Tests\Feature;

use Tests\TestCase;

class EnableFlagBitTest extends TestCase
{
    /**
     * Enable Flag Bits Test
     *
     * @return void
     */
    public function test_enableFlagBits(): void
    {
        $flagBitId = 1;
        $transactionId = 4;

        $response = $this->withHeaders(['X-Header' => 'Value'])
            ->post('/api/enable_flagBit',
                ['trans_id' => $transactionId, 'flagbit_id' => $flagBitId],
                ['x-api-key' => '3ae7824c75f1aef362dab353bfceee6722c1f6f9']
            );
        $response->assertSee(["FlagBit set Successful!"]);
        $response->assertStatus(200);
    }

    /**
     * Enable Flag Bits Test Has Missing Keys
     *
     * @return void
     */
    public function test_enableflagbitsHasMissingKeys(): void
    {
        $flagBitId = null;
        $transactionId = null;

        $response = $this->withHeaders(['X-Header' => 'Value'])
            ->post('/api/enable_flagBit',
                ['trans_id' => $transactionId, 'flagbit_id' => $flagBitId],
                ['x-api-key' => '3ae7824c75f1aef362dab353bfceee6722c1f6f9']
            );
        $response->assertSee(["Transaction Id or FlagBit Id is Missing!"]);
        $response->assertStatus(401);
    }
}
