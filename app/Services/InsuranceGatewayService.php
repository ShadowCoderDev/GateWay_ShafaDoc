<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class InsuranceGatewayService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false,
        ]);
    }

    /**
     * دریافت لیست بیمه‌ها
     */
    public function getInsurances(array $params = []): array
    {
        try {
            $response = $this->client->get(
                config('services.microservices.patient.url') . '/api/v1/patients-mic/insurances',
                [
                    'query' => $params,
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            return [
                'status_code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents()
            ];

        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null;

            return [
                'status_code' => $statusCode,
                'body' => $responseBody ?? json_encode([
                        'success' => false,
                        'message' => 'خطا در ارتباط با سرویس بیمه‌ها'
                    ])
            ];
        } catch (GuzzleException $e) {
            return [
                'status_code' => 500,
                'body' => json_encode([
                    'success' => false,
                    'message' => 'خطای غیرمنتظره در ارتباط با سرویس بیمه‌ها'
                ])
            ];
        }
    }

    /**
     * دریافت اطلاعات یک بیمه
     */
    public function getInsurance($id): array
    {
        try {
            $response = $this->client->get(
                config('services.microservices.patient.url') . "/api/v1/patients-mic/insurances/{$id}",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            return [
                'status_code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents()
            ];

        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null;

            return [
                'status_code' => $statusCode,
                'body' => $responseBody ?? json_encode([
                        'success' => false,
                        'message' => 'خطا در ارتباط با سرویس بیمه‌ها'
                    ])
            ];
        } catch (GuzzleException $e) {
            return [
                'status_code' => 500,
                'body' => json_encode([
                    'success' => false,
                    'message' => 'خطای غیرمنتظره در ارتباط با سرویس بیمه‌ها'
                ])
            ];
        }
    }

    /**
     * ایجاد بیمه جدید
     */
    public function createInsurance(array $data): array
    {
        try {
            $response = $this->client->post(
                config('services.microservices.patient.url') . '/api/v1/patients-mic/insurances',
                [
                    'json' => $data,
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            return [
                'status_code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents()
            ];

        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null;

            return [
                'status_code' => $statusCode,
                'body' => $responseBody ?? json_encode([
                        'success' => false,
                        'message' => 'خطا در ارتباط با سرویس بیمه‌ها'
                    ])
            ];
        } catch (GuzzleException $e) {
            return [
                'status_code' => 500,
                'body' => json_encode([
                    'success' => false,
                    'message' => 'خطای غیرمنتظره در ارتباط با سرویس بیمه‌ها'
                ])
            ];
        }
    }

    /**
     * بروزرسانی بیمه
     */
    public function updateInsurance($id, array $data): array
    {
        try {
            $response = $this->client->put(
                config('services.microservices.patient.url') . "/api/v1/patients-mic/insurances/{$id}",
                [
                    'json' => $data,
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            return [
                'status_code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents()
            ];

        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null;

            return [
                'status_code' => $statusCode,
                'body' => $responseBody ?? json_encode([
                        'success' => false,
                        'message' => 'خطا در ارتباط با سرویس بیمه‌ها'
                    ])
            ];
        } catch (GuzzleException $e) {
            return [
                'status_code' => 500,
                'body' => json_encode([
                    'success' => false,
                    'message' => 'خطای غیرمنتظره در ارتباط با سرویس بیمه‌ها'
                ])
            ];
        }
    }

    /**
     * حذف بیمه
     */
    public function deleteInsurance($id): array
    {
        try {
            $response = $this->client->delete(
                config('services.microservices.patient.url') . "/api/v1/patients-mic/insurances/{$id}",
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            return [
                'status_code' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents()
            ];

        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null;

            return [
                'status_code' => $statusCode,
                'body' => $responseBody ?? json_encode([
                        'success' => false,
                        'message' => 'خطا در ارتباط با سرویس بیمه‌ها'
                    ])
            ];
        } catch (GuzzleException $e) {
            return [
                'status_code' => 500,
                'body' => json_encode([
                    'success' => false,
                    'message' => 'خطای غیرمنتظره در ارتباط با سرویس بیمه‌ها'
                ])
            ];
        }
    }
}
