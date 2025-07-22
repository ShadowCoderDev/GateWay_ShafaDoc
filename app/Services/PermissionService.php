<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class PermissionService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'verify' => false,
        ]);
    }


    public function checkPermission($token, $permission): array
    {
        try {
            $response = $this->client->post(
                config('services.microservices.auth.url') . '/api/v1/permission/check',
                [
                    'json' => [
                        'permission' => $permission
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => true,
                'has_permission' => $data['data']['has_permission'] ?? false,
                'user_id' => $data['data']['user_id'] ?? null,
                'status_code' => $response->getStatusCode()
            ];

        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;
            $responseBody = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null;

            Log::error('Permission check failed:', [
                'permission' => $permission,
                'status' => $statusCode,
                'response' => $responseBody
            ]);

            return [
                'success' => false,
                'has_permission' => false,
                'error' => 'خطا در بررسی دسترسی',
                'status_code' => $statusCode
            ];
        } catch (GuzzleException) {

            return [
                'success' => false,
                'message' => 'خطای غیرمنتظره در ارتباط با سرویس احراز هویت',
                'status' => 500
            ];
        }
    }


    public function checkMultiplePermissions($token, $permissions): array
    {
        try {
            $response = $this->client->post(
                config('services.microservices.auth.url') . '/api/v1/permission/check-multiple',
                [
                    'json' => [
                        'permissions' => $permissions
                    ],
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ]
                ]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => true,
                'has_all_permissions' => $data['data']['has_all_permissions'] ?? false,
                'permissions_check' => $data['data']['permissions_check'] ?? [],
                'user_id' => $data['data']['user_id'] ?? null,
                'status_code' => $response->getStatusCode()
            ];

        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500;

            return [
                'success' => false,
                'has_all_permissions' => false,
                'error' => 'خطا در بررسی دسترسی‌ها',
                'status_code' => $statusCode
            ];
        } catch (GuzzleException) {

            return [
                'success' => false,
                'message' => 'خطای غیرمنتظره در ارتباط با سرویس احراز هویت',
                'status' => 500
            ];
        }
    }


    public function getUserPermissions($token): array
    {
        try {
            $response = $this->client->get(
                config('services.microservices.auth.url') . '/api/v1/permission/user-permissions',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json'
                    ]
                ]
            );

            $data = json_decode($response->getBody()->getContents(), true);

            return [
                'success' => true,
                'user_permissions' => $data['data']['permissions'] ?? [],
                'user_roles' => $data['data']['roles'] ?? [],
                'status_code' => $response->getStatusCode()
            ];

        } catch (RequestException $e) {
            return [
                'success' => false,
                'user_permissions' => [],
                'error' => 'خطا در دریافت دسترسی‌های کاربر',
                'status_code' => $e->hasResponse() ? $e->getResponse()->getStatusCode() : 500
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
