<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class ServerTime extends Controller
{
    /**
     * Current Server Time Controller
     *
     * @return JsonResponse Json Response
     */
    public function currentServerTime(): JsonResponse
    {
        return response()->json([
            'Server Time' => Carbon::now()->toDate(),
            'timestamp' => time(),
            'time_miliseconds' => round(microtime(true) * 1000),
        ], 200,
            [
                'Content-Type' => 'application/json',
                'Charset' => 'utf-8'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
