<?php

namespace App\Http\Controllers\Api\V1\Gateway;

use App\Http\Controllers\Controller;
use App\Services\InsuranceGatewayService;
use Illuminate\Http\Request;

class InsuranceGatewayController extends Controller
{
    private InsuranceGatewayService $gatewayService;

    public function __construct(InsuranceGatewayService $gatewayService)
    {
        $this->gatewayService = $gatewayService;
    }

    /**
     * نمایش لیست تمام بیمه‌ها
     */
    public function index(Request $request)
    {
        // دریافت پارامترهای جستجو از درخواست
        $params = $request->all();

        $result = $this->gatewayService->getInsurances($params);

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }

    /**
     * نمایش اطلاعات یک بیمه خاص
     */
    public function show($id)
    {
        $result = $this->gatewayService->getInsurance($id);

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }

    /**
     * ایجاد بیمه جدید
     */
    public function store(Request $request)
    {
        // دریافت تمام داده‌های ارسالی
        $data = $request->all();

        $result = $this->gatewayService->createInsurance($data);

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }

    /**
     * بروزرسانی اطلاعات بیمه
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $result = $this->gatewayService->updateInsurance($id, $data);

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }

    /**
     * حذف بیمه
     */
    public function destroy($id)
    {
        $result = $this->gatewayService->deleteInsurance($id);

        return response($result['body'], $result['status_code'])
            ->header('Content-Type', 'application/json');
    }
}
