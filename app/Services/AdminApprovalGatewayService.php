<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class AdminApprovalGatewayService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false,
        ]);
    }


    public function approveAdmin($userId, $token): array
    {
        try {
            $response = $this->client->patch(
                config('services.microservices.auth.url') . '/api/v1/admin/approve/' . $userId,
                [
                    'json' => [],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
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
                        'message' => 'خطا در ارتباط با سرویس احراز هویت'
                    ])
            ];
        } catch (GuzzleException) {

            return [
                'success' => false,
                'message' => 'خطای غیرمنتظره در ارتباط با سرویس احراز هویت',
                'status' => 500
            ];
        }
    }


    public function rejectAdmin($userId, $reason, $token): array
    {
        try {
            $response = $this->client->patch(
                config('services.microservices.auth.url') . '/api/v1/admin/reject/' . $userId,
                [
                    'json' => ['reason' => $reason],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
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
                        'message' => 'خطا در ارتباط با سرویس احراز هویت'
                    ])
            ];
        } catch (GuzzleException) {

            return [
                'success' => false,
                'message' => 'خطای غیرمنتظره در ارتباط با سرویس احراز هویت',
                'status' => 500
            ];
        }
    }
}
