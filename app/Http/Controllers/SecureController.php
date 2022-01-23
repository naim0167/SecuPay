<?php

namespace App\Http\Controllers;

use App\Providers\AuthenticationServiceProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SecureController extends Controller
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
     * Check If Api Is Authenticated
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function apiSecured(Request $request): JsonResponse
    {
        $isValid = $this->authenticationService->apiAuthentication($request);
        if (!$isValid) {
            return response()->json(['Unauthenticated!'], 401,
                [
                    'Content-Type' => 'application/json',
                    'Charset' => 'utf-8'
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return response()->json("Endpoint is secured by x-api-key.", 200,
            [
                'Content-Type' => 'application/json',
                'Charset' => 'utf-8'
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

}
