<?php

namespace App\Http\Controllers;

use App\Providers\AuthenticationServiceByMasterKeyProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RemoveFlagBitController extends Controller
{
    private AuthenticationServiceByMasterKeyProvider $authenticationServiceByMasterKeyProvider;

    /**
     * @param AuthenticationServiceByMasterKeyProvider $authenticationServiceByMasterKeyProvider Authentication Service by Master Key
     */
    public function __construct(AuthenticationServiceByMasterKeyProvider $authenticationServiceByMasterKeyProvider)
    {
        $this->authenticationServiceByMasterKeyProvider = $authenticationServiceByMasterKeyProvider;
    }

    /**
     * Check transaction
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deactivateFlagBit(Request $request): JsonResponse
    {
        $hasValidMasterKey = $this->authenticationServiceByMasterKeyProvider->apiAuthenticationHasMasterKey($request);
        if (!$hasValidMasterKey) {
            return response()->json(['Unauthenticated!'], 401,
                [
                    'Content-Type' => 'application/json',
                    'Charset' => 'utf-8'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $hasMasterKey = get_object_vars($hasValidMasterKey[0])['ist_masterkey'];

        if ($hasMasterKey !== 1) {
            return response()->json(['MasterKey not assigned!'], 401,
                [
                    'Content-Type' => 'application/json',
                    'Charset' => 'utf-8'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $transactionId = $request->input('trans_id') ?? '';
        $flagBitId = $request->input('flagbit_id') ?? '';
        if ((!$transactionId) || (!$flagBitId)) {
            return response()->json(['Transaction Id or FlagBit Id is Missing!'], 401,
                [
                    'Content-Type' => 'application/json',
                    'Charset' => 'utf-8'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $this->removeFlagBit($transactionId, $flagBitId);

        return response()->json(['FlagBit removed Successfully!'], 200,
            [
                'Content-Type' => 'application/json',
                'Charset' => 'utf-8'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    }

    /**
     * Remove FlagBit for some transaction
     *
     * @param $transactionId
     * @param $flagBitId
     */
    public function removeFlagBit($transactionId, $flagBitId): void
    {
        DB::table('flagbit_transactions')
            ->where('trans_id', '=', $transactionId)
            ->where('flagbit_id', '=', $flagBitId)
            ->update(['active' => 0]);
    }

}
