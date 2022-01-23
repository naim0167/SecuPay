<?php

namespace App\Http\Controllers;

use App\Providers\AuthenticationServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
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
    public function transactionById(Request $request): JsonResponse
    {
        $isValid = $this->authenticationService->apiAuthentication($request);
        if (!$isValid) {
            return response()->json(['Unauthenticated!'], 401,
                [
                    'Content-Type' => 'application/json',
                    'Charset' => 'utf-8'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $transactionDetails = $this->getTransactionDetailsById($request);
        if (empty($transactionDetails) === true) {
            return response()->json('Entity was not found / Wrong Input!', 404,
                [
                    'Content-Type' => 'application/json',
                    'Charset' => 'utf-8'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $transaction = get_object_vars($transactionDetails[0]);

        return response()->json([
            'trans_id' => $transaction['trans_id'],
            'produkt_id' => $transaction['produkt_id'],
            'vertrag_id' => $transaction['vertrag_id'],
            'Betrag' => $transaction['Betrag'],
            'beschreibung' => $transaction['beschreibung'],
            'waehrung_id' => $transaction['waehrung_id'],
            'bearbeiter' => $transaction['bearbeiter'],
            'erstelldatum' => $transaction['erstelldatum'],
            'timestamp' => $transaction['timestamp'],
            'zeitraum_id' => $transaction['zeitraum_id'],
            'nutzer_id' => $transaction['nutzer_id'],
            'Bearbeiter' => $transaction['Bearbeiter']
        ], 200,
            [
                'Content-Type' => 'application/json',
                'Charset' => 'utf-8'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    }

    /**
     * Get a transaction detail by transaction Id
     *
     * @param Request $request
     * @return array
     */
    public function getTransactionDetailsById(Request $request): array
    {
        $transactionId = $request->input('trans_id') ?? '';

        $transactionDetails = DB::table('transaktion_transaktionen')
            ->join('vertragsverw_vertrag', 'transaktion_transaktionen.vertrag_id', '=', 'vertragsverw_vertrag.vertrag_id')
            ->where('transaktion_transaktionen.trans_id', '=', $transactionId)
            ->select('*')
            ->get();

        return $transactionDetails->all();
    }


}
