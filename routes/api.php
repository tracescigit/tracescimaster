<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\Api\CodeActivationController;
use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ScanController;
use App\Http\Controllers\Api\SupplyChain\ScanController as SupplyChainScanController;
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

Route::post('/get-otp', [AuthController::class, 'getOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('password-login', [AuthController::class, 'passwordLogin']);
Route::post('/p/{code}', [ScanController::class, 'show']);
Route::post('scan-history', [ScanController::class, 'scanHistory']);
Route::post('scan-details/{code}', [ScanController::class, 'scanDetails']);
Route::post('profile', [ProfileController::class, 'profile']);
Route::post('report', [ReportController::class, 'report']);
Route::post('assigned-cases', [CaseController::class, 'assignedCases']);
Route::post('case-details/{id}', [CaseController::class, 'caseDetails']);
Route::post('update-case/{id}', [CaseController::class, 'updateCase']);
Route::post('deactivate-product', [CodeController::class, 'deactivate']);
Route::post('without-auth', [AuthController::class, 'withoutAuth']);
Route::post('activate-codes', [CodeActivationController::class, 'activate']);
Route::post('upload-scan-data', [CodeActivationController::class, 'upload']);
Route::post('redeem-points', [ScanController::class, 'redeemPoints']);
Route::post('order-product', [ScanController::class, 'orderProduct']);
Route::post('redeem-rewards', [ScanController::class, 'redeemRewards']);

Route::group(['prefix'=>'supply-chain'],function(){
    Route::post('scan', [SupplyChainScanController::class, 'scan']);
    Route::post('scan-history', [SupplyChainScanController::class, 'scanHistory']);
    Route::post('action', [SupplyChainScanController::class, 'action']);
});

//Redirect for browser
Route::get('/p/{code}', function ($code) {
    return redirect('/p/'.$code);
});


