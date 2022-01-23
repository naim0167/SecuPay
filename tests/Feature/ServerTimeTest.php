<?php

namespace Tests\Feature;

use Tests\TestCase;

class ServerTimeTest extends TestCase
{
    /**
     * Test get current server time
     *
     * @return void
     */
    public function test_currentServerTime()
    {
        $response = $this->get('/api/current_server_time');

        $response->assertStatus(200);
    }
}
