<?php

namespace App\Http\Controllers;

use App\Providers\AuthenticationServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class FlagBitsController extends Controller
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
     * Get the name of active flagbits (since there is no column called active so we are getting all of them)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function flagBits(Request $request): JsonResponse
    {
        $isValid = $this->authenticationService->apiAuthentication($request);
        if (!$isValid) {
            return response()->json(['Unauthenticated!'], 401,
                [
                    'Content-Type' => 'application/json',
                    'Charset' => 'utf-8'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $allFlagBits = $this->getAllFlagBits();

        if ((empty($allFlagBits) === true) || $allFlagBits === null) {
            return response()->json(['There is no flagbits'], 401,
                [
                    'Content-Type' => 'application/json',
                    'Charset' => 'utf-8'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $dataFlagConstantsList = Config::get('constants.dataflag');
        foreach ($allFlagBits as $activeFlagBit) {
            $flagBitNumber = get_object_vars($activeFlagBit)['flagbit'];
            $flagBitName[] = array_search($flagBitNumber, $dataFlagConstantsList, true);
        }
        return response()->json(['Data Flag' => $flagBitName], 200,
            [
                'Content-Type' => 'application/json',
                'Charset' => 'utf-8'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get All FlagBits
     *
     * @return array
     */
    private function getAllFlagBits(): array
    {
        $flagbits = DB::table('stamd_flagbit_ref')
            ->join('vorgaben_flagbit', 'stamd_flagbit_ref.flagbit', '=', 'vorgaben_flagbit.flagbit_id')
            ->select('stamd_flagbit_ref.flagbit')
            ->get();
        return $flagbits->all();
    }

    /**
     * Get Active flagbits
     *
     * @return array
     */
    private function getActiveFlagBitsList(): array
    {
        $flagbits = DB::table('flagbit_transactions')
            ->where('active', '=', 1)
            ->select('flagbit_transactions.flagbit_id')
            ->groupBy('flagbit_id')
            ->get();
        return $flagbits->all();
    }

}
