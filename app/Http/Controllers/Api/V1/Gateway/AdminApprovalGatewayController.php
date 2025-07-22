<?php

namespace App\Http\Controllers\Api\V1\Gateway;

use App\Http\Controllers\Controller;
use App\Services\AdminApprovalGatewayService;
use Illuminate\Http\Request;

class AdminApprovalGatewayController extends Controller
{
    private AdminApprovalGatewayService $gatewayService;

    public function __construct(AdminApprovalGatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }


    public function approve(Request $request, $userId)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'احراز هویت مورد نیاز هست اش '], 401);
        }

        if (!is_numeric($userId) || $userId <= 0) {
            return response()->json(['success' => false, 'message' => 'شناسه کاربر نامعتبر است'], 422);
        }

        $result = $this->gatewayService->approveAdmin($userId, $token);

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }


    public function reject(Request $request, $userId)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'احراز هویت مورد نیاز هست اش'], 401);
        }

        if (!is_numeric($userId) || $userId <= 0) {
            return response()->json(['success' => false, 'message' => 'شناسه کاربر نامعتبر است'], 422);
        }

        $request->validate([
            'reason' => 'required|string|min:5|max:500'
        ]);

        $result = $this->gatewayService->rejectAdmin($userId, $request->reason, $token);

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }
}
