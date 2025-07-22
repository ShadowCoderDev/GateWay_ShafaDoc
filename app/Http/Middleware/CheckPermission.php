<?php


namespace App\Http\Middleware;

use App\Services\PermissionService;
use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    private PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }


    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token مورد نیاز است'
            ], 401);
        }

        if (count($permissions) === 1) {
            $permission = $permissions[0];

            if (str_contains($permission, '|')) {
                $orPermissions = explode('|', $permission);
                $hasAnyPermission = false;

                foreach ($orPermissions as $orPermission) {
                    $result = $this->permissionService->checkPermission($token, trim($orPermission));

                    if (!$result['success']) {
                        return response()->json([
                            'success' => false,
                            'message' => 'خطا در بررسی دسترسی'
                        ], 500);
                    }

                    if ($result['has_permission']) {
                        $hasAnyPermission = true;
                        break;
                    }
                }

                if (!$hasAnyPermission) {
                    return response()->json([
                        'success' => false,
                        'message' => 'شما دسترسی لازم برای این عملیات را ندارید'
                    ], 403);
                }
            } else {
                $result = $this->permissionService->checkPermission($token, $permission);

                if (!$result['success']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'خطا در بررسی دسترسی'
                    ], 500);
                }

                if (!$result['has_permission']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'شما دسترسی لازم برای این عملیات را ندارید'
                    ], 403);
                }
            }
        } else {
            $result = $this->permissionService->checkMultiplePermissions($token, $permissions);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در بررسی دسترسی‌ها'
                ], 500);
            }

            if (!$result['has_all_permissions']) {
                return response()->json([
                    'success' => false,
                    'message' => 'شما تمام دسترسی‌های لازم برای این عملیات را ندارید'
                ], 403);
            }
        }

        return $next($request);
    }
}
