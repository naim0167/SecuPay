<?php

namespace Tests\Feature;

use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * Test get transaction
     *
     * @return void
     */
    public function test_transactionTest(): void
    {
        $transactionId = 4;
        $data = [
            "trans_id" => 4,
            "produkt_id" => 1,
            "vertrag_id" => 2,
            "Betrag" => 23,
            "beschreibung" => "Order #4",
            "waehrung_id" => 1,
            "bearbeiter" => 3,
            "erstelldatum" => "2021-09-02 00:26:44",
            "timestamp" => "2021-09-02 02:26:44",
            "zeitraum_id" => 2,
            "nutzer_id" => 3,
            "Bearbeiter" => 1
        ];

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->get('/api/transaction?trans_id=' . $transactionId, [
            'x-api-key' => '3ae7824c75f1aef362dab353bfceee6722c1f6f9',
        ]);
        $response->assertSee($data);
        $response->assertStatus(200);
    }
}
