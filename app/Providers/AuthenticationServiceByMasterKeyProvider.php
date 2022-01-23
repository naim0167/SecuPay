<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthenticationServiceByMasterKeyProvider
{
    public function apiAuthenticationHasMasterKey(Request $request): array
    {
        $apiKey = $request->header('x-api-key') ?? '';

        $validKey = DB::table('api_apikey')
            ->join('vorgaben_zeitraum', 'api_apikey.zeitraum_id', '=', 'vorgaben_zeitraum.zeitraum_id')
            ->where('api_apikey.apikey', '=', $apiKey)
            ->get();

        return $validKey->all();
    }
}
