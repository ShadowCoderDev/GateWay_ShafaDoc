<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class RefreshTokenGatewayService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false,
        ]);
    }


    public function refreshToken($token): array
    {
        try {
            $response = $this->client->post(
                config('services.microservices.auth.url') . '/api/v1/refresh',
                [
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
