<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\CheckRenewalAPIController;
use App\Http\Controllers\ActivationEmailController;
use App\Http\Controllers\BlockActCodeController;
use App\Http\Controllers\BlockKeysController;
use App\Http\Controllers\CheckValidKeyController;
use App\Http\Controllers\KeyDetailsApiController;
use App\Http\Controllers\LicDetailsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostActHwDataController;
use App\Http\Controllers\SkipKeysController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckIpAPI;

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

Route::post('smsapi',               [APIController::class, 'smsapi']);
Route::post('AddBookmark',          [APIController::class, 'AddBookmark']);
Route::get('IsIpWhitelisted',       [APIController::class, 'IsIpWhitelisted']);
Route::post('check_renewal',        [CheckRenewalAPIController::class, 'index']);
Route::get("/send_activation_mail", [ActivationEmailController::class, 'index']);
Route::post("/fetch_lic_details",   [LicDetailsController::class, 'fetch_lic_details'])->name('fetch_lic_details');

/** For Test Purpose Only */
Route::get('writeTestKey',         [PageController::class, 'writeTestKey']);
Route::get('readReactKey',         [PageController::class, 'readReactKey']);

/**
 * Block Key
 */

Route::middleware([CheckIpAPI::class])->group(function () {
    Route::post('blockKey',                          [BlockActCodeController::class, 'blockKey']);
    Route::post('checkLicKeyActivationStatus',       [BlockActCodeController::class, 'checkLicKeyActivationStatus']);
    Route::get('getKeyDetails',                      [KeyDetailsApiController::class, 'getKeyDetails']);
});


Route::post('checkUcBlock',                      [BlockActCodeController::class, 'checkUcBlock']);

/** Post HW DAta TO ACTHWMASTER */
Route::post('posthwdata',                      [PostActHwDataController::class, 'postDataToActHw']);

// Route::get('removeDupl', [UserController::class, 'removeDupl']);
Route::get('updateDuplicateRewardKeys',         [SkipKeysController::class, 'updateDuplicateRewardKeys']);

/**
 * Check If Key is valid or not
 */
Route::post('IsKeyValid',  [CheckValidKeyController::class, 'IsKeyValid']);
