<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Gateway\LoginGatewayController;
use App\Http\Controllers\Api\V1\Gateway\LogoutGatewayController;
use App\Http\Controllers\Api\V1\Gateway\AdminRegistrationGatewayController;
use App\Http\Controllers\Api\V1\Gateway\AdminApprovalGatewayController;

Route::prefix('gateway')->group(function () {
    Route::post('/login', [LoginGatewayController::class, 'login']);
    Route::post('logout', [LogoutGatewayController::class, 'logout']);
    Route::post('register/admin-one',[AdminRegistrationGatewayController::class, 'registerAdminOne']);
    Route::post('register/admin-two',[AdminRegistrationGatewayController::class, 'registerAdminTwo']);
    Route::post('register/admin-three',[AdminRegistrationGatewayController::class, 'registerAdminThree']);
    Route::patch('/admin/approve/{id}', [AdminApprovalGatewayController::class, 'approve'])
        ->where('id', '[0-9]+');
    Route::patch('/admin/reject/{id}', [AdminApprovalGatewayController::class, 'reject'])
        ->where('id', '[0-9]+');
});



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
