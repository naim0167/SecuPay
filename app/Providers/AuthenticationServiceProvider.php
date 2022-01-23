<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthenticationServiceProvider
{
    /**
     * @param Request $request
     * @return bool
     */
    public function apiAuthentication(Request $request): bool
    {
        $apiKey = $request->header('x-api-key') ?? '';

        return $this->checkApiKeyIsValid($apiKey);
    }

    /**
     * Check if api is valid
     *
     * @param string $apiKey Api Key
     * @return bool
     */

    private function checkApiKeyIsValid(string $apiKey): bool
    {
        $validKey = DB::table('api_apikey')
            ->join('vorgaben_zeitraum', 'api_apikey.zeitraum_id', '=', 'vorgaben_zeitraum.zeitraum_id')
            ->where('api_apikey.apikey', $apiKey)
            ->select('api_apikey.*')
            ->get();

        return count($validKey);
    }
}
