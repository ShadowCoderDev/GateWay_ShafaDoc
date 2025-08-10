<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Gateway\LoginGatewayController;
use App\Http\Controllers\Api\V1\Gateway\LogoutGatewayController;
use App\Http\Controllers\Api\V1\Gateway\AdminRegistrationGatewayController;
use App\Http\Controllers\Api\V1\Gateway\AdminApprovalGatewayController;
use App\Http\Controllers\Api\V1\Gateway\RefreshTokenGatewayController;
use App\Http\Controllers\Api\V1\Gateway\InsuranceGatewayController ;
use App\Http\Controllers\Api\V1\Gateway\PatientGatewayController  ;

Route::prefix('gateway')->group(function () {

    // ==================== Authentication Routes ====================

    Route::post('/refresh', [RefreshTokenGatewayController::class, 'refresh']);
    Route::post('/login', [LoginGatewayController::class, 'login']);
    Route::post('logout', [LogoutGatewayController::class, 'logout']);

    // Admin Registration
    Route::post('register/admin-one',[AdminRegistrationGatewayController::class, 'registerAdminOne']);
    Route::post('register/admin-two',[AdminRegistrationGatewayController::class, 'registerAdminTwo']);
    Route::post('register/admin-three',[AdminRegistrationGatewayController::class, 'registerAdminThree']);

    //  Admin Approval
    Route::patch('/admin/approve/{id}', [AdminApprovalGatewayController::class, 'approve'])
        ->where('id', '[0-9]+');
    Route::patch('/admin/reject/{id}', [AdminApprovalGatewayController::class, 'reject'])
        ->where('id', '[0-9]+');

    // ==================== Related Routes Permission ====================


    //  Billing Routes
    Route::group(['middleware' => 'permission:billing.view|billing.edit'], function () {
        Route::get('/billing', function (Request $request) {
            return response()->json(['message' => 'لیست صورتحساب‌ها (مشاهده)']);
        });

        Route::group(['middleware' => 'permission:billing.edit'], function () {
            Route::post('/billing', function (Request $request) {
                return response()->json(['message' => 'صورتحساب جدید ثبت شد (ویرایش)']);
            });
        });
    });

    //  Patients Routes

    Route::group(['middleware' => 'permission:patients.view|patients.edit'], function () {

        Route::get('/patients', [PatientGatewayController::class, 'index']);

        Route::get('/patients/{id}', [PatientGatewayController::class, 'show'])
            ->where('id', '[0-9]+');

        Route::group(['middleware' => 'permission:patients.edit'], function () {

            Route::post('/patients', [PatientGatewayController::class, 'store']);

            Route::put('/patients/{id}', [PatientGatewayController::class, 'update'])
                ->where('id', '[0-9]+');

            Route::delete('/patients/{id}', [PatientGatewayController::class, 'destroy'])
                ->where('id', '[0-9]+');
        });
    });


    //  Insurance Routes
    Route::group(['middleware' => 'permission:insurances.view|insurances.edit'], function () {

        Route::get('/insurances', [InsuranceGatewayController::class, 'index']);

        Route::get('/insurances/{id}', [InsuranceGatewayController::class, 'show'])
            ->where('id', '[0-9]+');

        Route::group(['middleware' => 'permission:insurances.edit'], function () {

            Route::post('/insurances', [InsuranceGatewayController::class, 'store']);

            Route::put('/insurances/{id}', [InsuranceGatewayController::class, 'update'])
                ->where('id', '[0-9]+');

            Route::delete('/insurances/{id}', [InsuranceGatewayController::class, 'destroy'])
                ->where('id', '[0-9]+');
        });
    });


});



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
