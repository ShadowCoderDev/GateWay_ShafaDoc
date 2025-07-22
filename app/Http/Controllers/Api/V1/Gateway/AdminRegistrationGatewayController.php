<?php

namespace App\Http\Controllers\Api\V1\Gateway;

use App\Http\Controllers\Controller;
use App\Enums\RolesEnum;
use App\Http\Requests\Api\V1\ApiAdminRegistrationRequest;
use App\Services\AdminRegistrationGatewayService;

class AdminRegistrationGatewayController extends Controller
{
    private AdminRegistrationGatewayService $gatewayService;

    public function __construct(AdminRegistrationGatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }


    private function registerAdmin(ApiAdminRegistrationRequest $request, RolesEnum $role)
    {
        $result = $this->gatewayService->registerAdmin(
            $request->name,
            $request->email,
            $request->national_code,
            $request->mobile,
            $request->password,
            $request->password_confirmation,
            $role->value
        );

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }

    /**
     * Admin One
     */
    public function registerAdminOne(ApiAdminRegistrationRequest $request)
    {
        return $this->registerAdmin($request, RolesEnum::ADMIN_ONE);
    }

    /**
     * Admin Two
     */
    public function registerAdminTwo(ApiAdminRegistrationRequest $request)
    {
        return $this->registerAdmin($request, RolesEnum::ADMIN_TWO);
    }

    /**
     * Admin Three
     */
    public function registerAdminThree(ApiAdminRegistrationRequest $request)
    {
        return $this->registerAdmin($request, RolesEnum::ADMIN_THREE);
    }
}
