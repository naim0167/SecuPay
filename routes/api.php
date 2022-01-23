<?php

use App\Http\Controllers\Authentication;
use App\Http\Controllers\AuthenticationService;
use App\Http\Controllers\FlagBitHistoryController;
use App\Http\Controllers\FlagBitsController;
use App\Http\Controllers\GetActiveFlagBitsController;
use App\Http\Controllers\RemoveFlagBitController;
use App\Http\Controllers\SecureController;
use App\Http\Controllers\ServerTime;
use App\Http\Controllers\SetFlagBitController;
use App\Http\Controllers\TransactionByUserController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/current_server_time', [ServerTime::class, 'currentServerTime']);
Route::get('/secure', [SecureController::class, 'apiSecured']);
Route::get('/flagbits', [FlagBitsController::class, 'flagBits']);
Route::get('/getActiveFlagBits', [GetActiveFlagBitsController::class, 'getActiveFlagBits']);
Route::get('/transaction', [TransactionController::class, 'transactionById']);
Route::get('/user_transaction', [TransactionByUserController::class, 'transactionByUser']);
Route::post('/enable_flagBit', [SetFlagBitController::class, 'activateFlagBit']);
Route::post('/disable_flagBit', [RemoveFlagBitController::class, 'deactivateFlagBit']);
Route::get('/flagBitHistory', [FlagBitHistoryController::class, 'getFlagBitHistory']);
