<?php

namespace App\Http\Controllers\Api\V1\Gateway;

use App\Http\Controllers\Controller;
use App\Services\PatientGatewayService;
use Illuminate\Http\Request;

class PatientGatewayController extends Controller
{
    private PatientGatewayService $gatewayService;

    public function __construct(PatientGatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }

    /**
     * دریافت لیست بیماران
     */
    public function index(Request $request)
    {
        $result = $this->gatewayService->getPatients($request->all());

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }

    /**
     * دریافت اطلاعات یک بیمار
     */
    public function show(Request $request, $id)
    {
        $result = $this->gatewayService->getPatient($id);

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }

    /**
     * ایجاد بیمار جدید
     */
    public function store(Request $request)
    {
        $result = $this->gatewayService->createPatient($request->all());

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }

    /**
     * بروزرسانی بیمار
     */
    public function update(Request $request, $id)
    {
        $result = $this->gatewayService->updatePatient($id, $request->all());

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }

    /**
     * حذف بیمار
     */
    public function destroy(Request $request, $id)
    {
        $result = $this->gatewayService->deletePatient($id);

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }
}
