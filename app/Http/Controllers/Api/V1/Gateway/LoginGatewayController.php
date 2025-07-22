<?php

namespace App\Http\Controllers\Api\V1\Gateway;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ApiLoginRequest;
use App\Services\LoginGatewayService;

class LoginGatewayController extends Controller
{
    private LoginGatewayService $gatewayService;

    public function __construct(LoginGatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }


    public function login(ApiLoginRequest $request)
    {
        $result = $this->gatewayService->loginToAuthService(
            $request->mobile,
            $request->password
        );

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }
}
