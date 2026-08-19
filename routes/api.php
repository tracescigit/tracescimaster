<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CaseController;
use App\Http\Controllers\Api\CodeActivationController;
use App\Http\Controllers\Api\CodeController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ScanController;
use App\Http\Controllers\Api\SupplyChain\ScanController as SupplyChainScanController;
use App\Http\Controllers\Api\Mobile\AuthController as MobileAuthController;
use App\Http\Controllers\Api\Mobile\AlertController as MobileAlertController;
use App\Http\Controllers\Api\Mobile\BrandController;
use App\Http\Controllers\Api\Mobile\ConsumerController;
use App\Http\Controllers\Api\Mobile\InspectorController;
use App\Http\Controllers\Api\Mobile\RewardController;
use App\Http\Controllers\Api\Mobile\SessionController;
use App\Http\Controllers\Api\Mobile\SupplyChainController;
use App\Http\Controllers\Api\Mobile\VerifyController;
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
Route::post('/verify-secret-code', [AuthController::class, 'verifySecretCode']);

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

Route::group(['prefix' => 'app/auth'], function () {
    Route::post('consumer/request-otp', [MobileAuthController::class, 'consumerRequestOtp']);
    Route::post('consumer/verify',      [MobileAuthController::class, 'consumerVerifyOtp']);
    Route::post('official/request-otp', [MobileAuthController::class, 'officialRequestOtp']);
    Route::post('official/verify',      [MobileAuthController::class, 'officialVerifyOtp']);
});

Route::group(['prefix' => 'app'], function () {
    Route::post('bootstrap',      [SessionController::class, 'bootstrap']);
    Route::post('me',             [SessionController::class, 'me']);
    Route::post('update-profile', [SessionController::class, 'updateProfile']);
    Route::post('masters',        [SessionController::class, 'masters']);
    Route::post('logout',         [SessionController::class, 'logout']);
    Route::post('delete-account', [SessionController::class, 'deleteAccount']);
});

Route::group(['prefix' => 'consumer'], function () {
    Route::post('home',            [ConsumerController::class, 'home']);
    Route::post('scans',           [ConsumerController::class, 'scans']);
    Route::post('scan/{scan_id}',  [ConsumerController::class, 'scanDetail']);
    Route::post('report',          [ConsumerController::class, 'report']);
    Route::post('reports',         [ConsumerController::class, 'reports']);
    Route::post('notifications',   [ConsumerController::class, 'notifications']);
    Route::post('diagnose',        [VerifyController::class, 'diagnose']);
});

Route::post('alerts', [MobileAlertController::class, 'feed']);

Route::group(['prefix' => 'rewards'], function () {
    Route::post('summary',        [RewardController::class, 'summary']);
    Route::post('ledger',         [RewardController::class, 'ledger']);
    Route::post('catalog',        [RewardController::class, 'catalog']);
    Route::post('redeem-coupon',  [RewardController::class, 'redeemCoupon']);
    Route::post('redeem-cash',    [RewardController::class, 'redeemCash']);
    Route::post('order',          [RewardController::class, 'placeOrder']);
    Route::post('orders',         [RewardController::class, 'orders']);
    Route::post('scan-to-redeem', [RewardController::class, 'scanToRedeem']);
    Route::post('transactions',   [RewardController::class, 'transactions']);
});

Route::group(['prefix' => 'supply-chain'], function () {
    Route::post('dashboard',                [SupplyChainController::class, 'dashboard']);
    Route::post('consignments',             [SupplyChainController::class, 'consignments']);
    Route::post('consignment/{unique_id}',  [SupplyChainController::class, 'consignment']);
    Route::post('timeline/{unique_id}',     [SupplyChainController::class, 'timeline']);
    Route::post('counterparties',           [SupplyChainController::class, 'counterpartyList']);
    Route::post('statuses',                 [SupplyChainController::class, 'statuses']);
    Route::post('my-activity',              [SupplyChainController::class, 'myActivity']);
    Route::post('team-activity',            [SupplyChainController::class, 'teamActivity']);
});

Route::group(['prefix' => 'inspector'], function () {
    Route::post('dashboard',        [InspectorController::class, 'dashboard']);
    Route::post('cases',            [InspectorController::class, 'cases']);
    Route::post('case/{id}',        [InspectorController::class, 'caseDetail']);
    Route::post('case/{id}/update', [InspectorController::class, 'updateCase']);
    Route::post('seize',            [InspectorController::class, 'seize']);
});

Route::group(['prefix' => 'brand'], function () {
    Route::post('dashboard',    [BrandController::class, 'dashboard']);
    Route::post('products',     [BrandController::class, 'products']);
    Route::post('product/{id}', [BrandController::class, 'product']);
    Route::post('product/{id}/journey', [BrandController::class, 'journey']);
    Route::post('scans',        [BrandController::class, 'scans']);
    Route::post('alerts',       [BrandController::class, 'alerts']);
    Route::post('network',      [BrandController::class, 'network']);
    Route::post('lookup',       [BrandController::class, 'lookup']);
    Route::post('deactivate',   [BrandController::class, 'deactivate']);
});

//Redirect for browser
Route::get('/p/{code}', function ($code) {
    return redirect('/p/'.$code);
});

