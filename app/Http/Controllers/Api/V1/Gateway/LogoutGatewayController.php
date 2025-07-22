<?php

namespace App\Http\Controllers\Api\V1\Gateway;

use App\Http\Controllers\Controller;
use App\Services\LogoutGatewayService;
use Illuminate\Http\Request;

class LogoutGatewayController extends Controller
{
    private LogoutGatewayService $gatewayService;

    public function __construct(LogoutGatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }


    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Token مورد نیاز است'], 401);
        }

        $result = $this->gatewayService->logoutFromAuthService($token);

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }
}
