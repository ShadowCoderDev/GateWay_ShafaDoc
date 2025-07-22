<?php

namespace App\Http\Controllers\Api\V1\Gateway;

use App\Http\Controllers\Controller;
use App\Services\RefreshTokenGatewayService;
use Illuminate\Http\Request;

class RefreshTokenGatewayController extends Controller
{
    private RefreshTokenGatewayService $gatewayService;

    public function __construct(RefreshTokenGatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }


    public function refresh(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Token مورد نیاز است'], 401);
        }

        $result = $this->gatewayService->refreshToken($token);

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }
}
