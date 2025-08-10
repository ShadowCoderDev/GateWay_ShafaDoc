<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class PatientGatewayService
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
     * دریافت لیست بیماران
     */
    public function getPatients(array $params = []): array
    {
        try {
            $response = $this->client->get(
                config('services.microservices.patient.url') . '/api/v1/patients-mic/patients',
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
                        'message' => 'خطا در ارتباط با سرویس بیماران'
                    ])
            ];
        } catch (GuzzleException $e) {
            return [
                'status_code' => 500,
                'body' => json_encode([
                    'success' => false,
                    'message' => 'خطای غیرمنتظره در ارتباط با سرویس بیماران'
                ])
            ];
        }
    }

    /**
     * دریافت اطلاعات یک بیمار
     */
    public function getPatient($id): array
    {
        try {
            $response = $this->client->get(
                config('services.microservices.patient.url') . "/api/v1/patients-mic/patients/{$id}",
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
                        'message' => 'خطا در ارتباط با سرویس بیماران'
                    ])
            ];
        } catch (GuzzleException $e) {
            return [
                'status_code' => 500,
                'body' => json_encode([
                    'success' => false,
                    'message' => 'خطای غیرمنتظره در ارتباط با سرویس بیماران'
                ])
            ];
        }
    }

    /**
     * ایجاد بیمار جدید
     */
    public function createPatient(array $data): array
    {
        try {
            $response = $this->client->post(
                config('services.microservices.patient.url') . '/api/v1/patients-mic/patients',
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
                        'message' => 'خطا در ارتباط با سرویس بیماران'
                    ])
            ];
        } catch (GuzzleException $e) {
            return [
                'status_code' => 500,
                'body' => json_encode([
                    'success' => false,
                    'message' => 'خطای غیرمنتظره در ارتباط با سرویس بیماران'
                ])
            ];
        }
    }

    /**
     * بروزرسانی بیمار
     */
    public function updatePatient($id, array $data): array
    {
        try {
            $response = $this->client->put(
                config('services.microservices.patient.url') . "/api/v1/patients-mic/patients/{$id}",
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
                        'message' => 'خطا در ارتباط با سرویس بیماران'
                    ])
            ];
        } catch (GuzzleException $e) {
            return [
                'status_code' => 500,
                'body' => json_encode([
                    'success' => false,
                    'message' => 'خطای غیرمنتظره در ارتباط با سرویس بیماران'
                ])
            ];
        }
    }

    /**
     * حذف بیمار
     */
    public function deletePatient($id): array
    {
        try {
            $response = $this->client->delete(
                config('services.microservices.patient.url') . "/api/v1/patients-mic/patients/{$id}",
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
                        'message' => 'خطا در ارتباط با سرویس بیماران'
                    ])
            ];
        } catch (GuzzleException $e) {
            return [
                'status_code' => 500,
                'body' => json_encode([
                    'success' => false,
                    'message' => 'خطای غیرمنتظره در ارتباط با سرویس بیماران'
                ])
            ];
        }
    }
}
