<?php

use App\Http\Controllers\ActController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlockKeysController;
use App\Http\Controllers\DealerRegController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\NewActController;
use App\Http\Controllers\SkipKeysController;
use App\Http\Controllers\StatewiseActController;
use App\Http\Controllers\TemplateController;
use App\Http\Middleware\CheckAsm;
use App\Http\Middleware\CheckLogin;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckIp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false,    // Password Reset Routes...
    'verify' => false,   // Email Verification Routes...
]);



Route::get('otp',  function () {
    return response()->view('SendOTP');
});

Route::get("logout",            [UserController::class, 'logout']);
Route::post('/sendOTPForm',     [PageController::class, 'sendOTPForm']);
Route::post('/validateOPT',     [PageController::class, 'validateOPT']);

// Route::any('/sureBlockUc',                        [PageController::class, 'sureBlockUc']);

Route::middleware([CheckIp::class])->group(function () {
    Route::get("/",             [UserController::class, 'login'])->name("/");
    route::any("CheckLogin",    [UserController::class, "CheckLogin"])->name('CheckLogin');
    // });

    // Route::get("logout",            [UserController::class, 'logout']);
    // Route::post('/sendOTPForm',     [PageController::class, 'sendOTPForm']);
    // Route::post('/validateOPT',     [PageController::class, 'validateOPT']);


    Route::get('updateDefaultVals', [UserController::class, 'updateDefaultVals']);

    Route::middleware([CheckLogin::class])->group(function () {

        Route::get('/dashboard/{KeyNo?}',               [PageController::class, 'dashboard']);

        // Route::post('/SearchByKey',                        [PageController::class, 'SearchByKey']);
        Route::get('/SearchByKey',                         [PageController::class, 'SearchByKey']);
        Route::post('/FetchHWDetails1',                    [PageController::class, 'FetchHWDetails1']);
        Route::get('/FetchHWDetails2/{custNo}/{lic}',      [PageController::class, 'FetchHWDetails2']);
        Route::post('/FetchUserDetails',                   [PageController::class, 'FetchUserDetails']);
        Route::post('/UpdateUserDetails',                  [PageController::class, 'UpdateUserDetails']);
        Route::post('/FetchUserMobDetails',                [PageController::class, 'FetchUserMobDetails']);
        Route::post('/UpdateUserMob',                      [PageController::class, 'UpdateUserMob']);
        Route::post('/FetchContactDetails',                [PageController::class, 'FetchContactDetails']);
        Route::post('/FetchReactivateDetails',             [PageController::class, 'FetchReactivateDetails']);
        Route::post('/FetchStateByCountry',                [PageController::class, 'FetchStateByCountry']);
        Route::post('/FetchDistrictByState',               [PageController::class, 'FetchDistrictByState']);
        Route::post('/UpdateReactivate',                   [PageController::class, 'UpdateReactivate']);
        Route::post('/genReactive',                        [PageController::class, 'genReactive']);
        Route::post('/getICcount',                         [PageController::class, 'getICcount']);
        Route::post('/SaveReactiveDetails',                [PageController::class, 'SaveReactiveDetails']);
        Route::post('/FetchUnLockCodeDetails',             [PageController::class, 'FetchUnLockCodeDetails']);
        Route::post('/UpdateUnlockCodeStatus',             [PageController::class, 'UpdateUnlockCodeStatus']);
        Route::post('/GetDlrScore',                        [PageController::class, 'GetDlrScore']);
        Route::post('/fetchRewardLog',                     [PageController::class, 'fetchRewardLog']);
        Route::get('/block_history/{serial_no}',           [PageController::class, 'show_block_history']);
        Route::post('/SendRewardMail',                     [PageController::class, 'SendRewardMail']);
        Route::post('/AddDays',                            [PageController::class, 'AddDays']);
        Route::get('/unlockCode_ad',                       [PageController::class, 'unlockCode_ad']);
        Route::get('/getSuggestedKeys',                    [PageController::class, 'getSuggestedKeys']);
        Route::get('/changeIP',                            [PageController::class, 'changeIP']);
        Route::post('/addNewIp',                           [PageController::class, 'addNewIp']);
        Route::get('/viewSentOTP',                         [PageController::class, 'viewSentOTP']);
        Route::get('/getFileContents',                     [PageController::class, 'getFileContents']);
        Route::post('/convertLic',                         [PageController::class, 'convertLic']);
        Route::get('/viewreactcnt',                        [PageController::class, 'viewreactcnt']);
        Route::get('/getUserwiseReactCnt',                 [PageController::class, 'getUserwiseReactCnt']);
        Route::get('/viewreactcntkeys/{date}/{operator}',  [PageController::class, 'viewreactcntkeys']);
        Route::get('/fetchCorpDetails',                    [PageController::class, 'fetchCorpDetails']);
        Route::post('/sureBlockUc',                        [PageController::class, 'sureBlockUc']);
        Route::get('/liveHwCount',                         [PageController::class, 'liveHwCount']);
        Route::get('/compNameCount',                       [PageController::class, 'compNameCount']);
        Route::get('/compterNameWiseCnt',                  [PageController::class, 'compterNameWiseCnt']);
        /**
         *
         */
        Route::post('/addToBookMark',                      [PageController::class, 'addToBookMark']);
        Route::get('/viewBookMarks',                       [PageController::class, 'viewBookMarks']);
        /**
         * Skip Keys
         */
        Route::get('/skipKeys',                          [SkipKeysController::class, 'skipKeys']);
        Route::post('/skipKeysFormData',                 [SkipKeysController::class, 'skipKeysFormData']);
        Route::get('/k2StatePolicy',                     [SkipKeysController::class, 'k2StatePolicy']);
        Route::post('/updatePolicy',                     [SkipKeysController::class, 'updatePolicy']);
        Route::get('/h2lSkipKeys',                       [SkipKeysController::class, 'h2lSkipKeys']);
        Route::post('/h2lSkipKeysInsert',                [SkipKeysController::class, 'h2lSkipKeysInsert']);
        //All Users
        Route::get('/allUsers',                         [UserController::class, 'allUsers']);
        Route::get('/getAllUsers',                      [UserController::class, 'getAllUsers']);
        Route::post('/updateUserStatus',                [UserController::class, 'updateUserStatus']);
        Route::post('/updateContactDetails',            [UserController::class, 'updateContactDetails']);
        Route::get('/UserPermissions',                  [UserController::class, 'UserPermissions']);
        Route::get('/getPermissionData',                [UserController::class, 'getPermissionData']);
        Route::post('/grantAccess',                     [UserController::class, 'grantAccess']);
        Route::get('/LoginHistory',                     [UserController::class, 'LoginHistory']);
        Route::get('/getUserActivity',                  [UserController::class, 'getUserActivity']);
        Route::post('/AddUser',                         [UserController::class, 'AddUser']);
        Route::get('/syncNewUsers',                     [UserController::class, 'syncNewUsers']);
        Route::get('/deleteUser',                       [UserController::class, 'deleteUser']);
        Route::post('/changeUserPass',                  [UserController::class, 'changeUserPass']);
        Route::any('/show_log',                        [PageController::class, 'ShowLog']);
        Route::post('/createNotes',                    [PageController::class, 'createNotes']);
        Route::post('/addRemark',                      [PageController::class, 'addRemark']);
        Route::post('/sendEmail',                      [PageController::class, 'sendEmail']);
        Route::post('/sendSMS',                        [PageController::class, 'sendSMS']);
        Route::post('/releaseKey',                     [PageController::class, 'releaseKey']);
        Route::get('/dlrActCount',                     [PageController::class, 'dlrActCount']);
        /**State Wise Activation Counter */
        Route::get('stateWiseActCount',                [StatewiseActController::class, 'stateWiseActCount']);
        Route::get('getStateWiseActCnt',               [StatewiseActController::class, 'getStateWiseActCnt']);
        Route::get('getDistrictWiseActCnt',            [StatewiseActController::class, 'getDistrictWiseActCnt']);
        /***Template Controller */
        Route::get('getTemplates',                     [TemplateController::class, 'getTemplates']);
        Route::post('addTemplate',                     [TemplateController::class, 'addTemplate']);
        Route::post('updateTemplate',                  [TemplateController::class, 'updateTemplate']);

        /***
         *Block Keys Controller
         */
        Route::get('blockKeys',                        [BlockKeysController::class, 'blockKeys']);
        Route::post('blockKeysFormData',               [BlockKeysController::class, 'blockKeysFormData']);
        Route::get('actGraph',                         [BlockKeysController::class, 'actGraphView']);
        Route::get('getGraphData',                     [BlockKeysController::class, 'getGraphData']);
        Route::get('getDistricts',                     [BlockKeysController::class, 'getDistricts']);

        /**
         *  Dealer Registration
         */
        Route::get('DealReg',                          [DealerRegController::class, 'DealReg']);
        Route::get('getDistrict',                      [DealerRegController::class, 'getDistrict']);
        Route::post('dealerRegister',                  [DealerRegController::class, 'dealerRegister']);
        Route::get('getDlrCode',                       [DealerRegController::class, 'getDlrCode']);


        /**
         * Act - REGISTRATION FOR ACTIVATION
         */

        Route::get('NewAct',                       [ActController::class, 'index']);
        Route::get('LoadOldLicDetails',            [ActController::class, 'LoadOldLicDetails']);
        Route::get('DealerInfo',                   [ActController::class, 'DealerInfo']);
        Route::get('enggInfo',                     [ActController::class, 'enggInfo']);
        Route::post('searchDealer',                [ActController::class, 'searchDealer']);
        Route::post('registerKeyForAct',           [ActController::class, 'registerKeyForAct']);
        Route::get('getCity',                      [ActController::class, 'getCity']);
        Route::get('showCityDlr',                  [ActController::class, 'showCityDlr']);


        /**
         * DLL Viewer
         */
        Route::get('ucdllViewer',                  [SkipKeysController::class, 'ucdllViewer']);
        Route::get('getRecords',                   [SkipKeysController::class, 'getRecords']);
        Route::get('monthWiseCnt',                 [SkipKeysController::class, 'monthWiseCnt']);
        Route::get('getMonthwiseCount',            [SkipKeysController::class, 'getMonthwiseCount']);

        /** Dealer Duplicate reward keys */
        Route::get('isAllowedToRewardKey',             [SkipKeysController::class, 'isAllowedToRewardKey']);
        Route::post('fetchNewRewardKey',               [SkipKeysController::class, 'fetchNewRewardKey']);
    });


    /** Add District */
    Route::get('AddDistrict',                      [ActController::class, 'AddDistrict']);
    Route::get('getAllDistricts',                  [ActController::class, 'getAllDistricts']);
    Route::post('addDistFormDate',                 [ActController::class, 'addDistFormDate']);
    Route::post('updateDist',                      [ActController::class, 'updateDist']);

    /** Clear Cache */
    Route::get('/cls', function () {
        Artisan::call('optimize:clear');
        return "Cleared!";
    });


    Route::get('/dump', function () {
        exec('composer dump-autoload -o');
        return 'Autoload dumped successfully!';
    });
});
Route::get("/stats/{Lic}", [PageController::class, 'stats']);
