<?php

namespace App\Http\Controllers;

use App\Providers\AuthenticationServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class GetActiveFlagBitsController extends Controller
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
     * Get Only Active Flagbit name
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getActiveFlagBits(Request $request): JsonResponse
    {
        $isValid = $this->authenticationService->apiAuthentication($request);
        if (!$isValid) {
            return response()->json(['Unauthenticated!'], 401,
                [
                    'Content-Type' => 'application/json',
                    'Charset' => 'utf-8'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $activeFlagBits = $this->getActiveFlagBitsList();
        if ((empty($activeFlagBits) === true) || $activeFlagBits === null) {
            return response()->json(['There is no flagbits'], 401,
                [
                    'Content-Type' => 'application/json',
                    'Charset' => 'utf-8'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $dataFlagConstantsList = Config::get('constants.dataflag');
        foreach ($activeFlagBits as $activeFlagBit) {
            $flagBitNumber = get_object_vars($activeFlagBit)['flagbit_id'];
            $flagBitName[] = array_search($flagBitNumber, $dataFlagConstantsList, true);
        }
        return response()->json(['Data Flag' => $flagBitName], 200,
            [
                'Content-Type' => 'application/json',
                'Charset' => 'utf-8'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get Active flagBits
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
