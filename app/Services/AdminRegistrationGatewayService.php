<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class AdminRegistrationGatewayService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false,
        ]);
    }


    public function registerAdmin(
        $name,
        $email,
        $national_code,
        $mobile,
        $password,
        $password_confirmation,
        $role
    ): array
    {
        try {
            $endpoint = $this->getEndpointByRole($role);

            $response = $this->client->post(
                config('services.microservices.auth.url') . '/api/v1' . $endpoint,
                [
                    'json' => [
                        'name' => $name,
                        'email' => $email,
                        'national_code' => $national_code,
                        'mobile' => $mobile,
                        'password' => $password,
                        'password_confirmation' => $password_confirmation,
                    ],
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


    private function getEndpointByRole($role): string
    {
        return match ($role) {
            'ADMIN_ONE' => '/auth/register/admin-one',
            'ADMIN_TWO' => '/auth/register/admin-two',
            'ADMIN_THREE' => '/auth/register/admin-three',
            default => '/auth/register/admin-one'
        };
    }
}
