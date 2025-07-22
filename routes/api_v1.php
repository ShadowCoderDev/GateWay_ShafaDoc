<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Gateway\LoginGatewayController;
use App\Http\Controllers\Api\V1\Gateway\LogoutGatewayController;
use App\Http\Controllers\Api\V1\Gateway\AdminRegistrationGatewayController;
use App\Http\Controllers\Api\V1\Gateway\AdminApprovalGatewayController;
use App\Http\Controllers\Api\V1\Gateway\RefreshTokenGatewayController;

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
        Route::get('/patients', function (Request $request) {
            return response()->json(['message' => 'لیست بیماران (مشاهده)']);
        });

        Route::group(['middleware' => 'permission:patients.edit'], function () {
            Route::post('/patients', function (Request $request) {
                return response()->json(['message' => 'بیمار جدید ثبت شد (ویرایش)']);
            });
        });
    });

});



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
