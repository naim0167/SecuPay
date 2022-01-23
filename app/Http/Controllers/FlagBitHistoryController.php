<?php

namespace App\Http\Controllers;

use App\Providers\AuthenticationServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlagBitHistoryController extends Controller
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
     * Get History of FlagBit
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFlagBitHistory(Request $request): JsonResponse
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
        if ((!$transactionId)) {
            return response()->json(['Transaction Id is Missing!'], 401,
                [
                    'Content-Type' => 'application/json',
                    'Charset' => 'utf-8'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        $historyList = $this->flagBitHistory($transactionId);
        return response()->json($historyList, 200,
            [
                'Content-Type' => 'application/json',
                'Charset' => 'utf-8'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    }

    /**
     *
     * History of FlagBits for some transactions
     *
     * @param $transactionId
     * @return array
     */
    public function flagBitHistory($transactionId): array
    {
        return DB::table('flagbit_transactions')
            ->where('trans_id', '=', $transactionId)
            ->select('flagbit_transactions.*')
            ->get()->all();
    }
}
