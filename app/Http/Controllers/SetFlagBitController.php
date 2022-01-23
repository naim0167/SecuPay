<?php

namespace App\Http\Controllers;

use App\Providers\AuthenticationServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetFlagBitController extends Controller
{
    private AuthenticationServiceProvider $authenticationService;

    /**
     * @param AuthenticationServiceProvider $authenticationService
     */
    public function __construct(AuthenticationServiceProvider $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * Check transaction
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function activateFlagBit(Request $request): JsonResponse
    {
        $valid = $this->authenticationService->apiAuthentication($request);
        if (!$valid) {
            return response()->json(['Unauthenticated!'], 401,
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
        $this->setFlagBit($transactionId, $flagBitId);

        return response()->json(['FlagBit set Successful!'], 200,
            [
                'Content-Type' => 'application/json',
                'Charset' => 'utf-8'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    }

    /**
     * Set Flag Bit for a transaction
     *
     * @param $transactionId
     * @param $flagBitId
     */
    public function setFlagBit($transactionId, $flagBitId): void
    {
        DB::table('flagbit_transactions')
            ->insert([
                'trans_id' => $transactionId,
                'flagbit_id' => $flagBitId,
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }


}
