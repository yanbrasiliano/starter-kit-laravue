<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\{LoginAction, LogoutAction, MyProfileAction};
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Authenticate\AuthenticateService;
use Illuminate\Http\JsonResponse;

/**
 * @apiInfo
 * @title SP 2.0
 * @version 1.0.0
 * @description staterkit
 */
class AuthenticateController extends Controller
{
    public function __construct(private AuthenticateService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = app(LoginAction::class)->execute($request->fluent());

            return response()->json($data);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], $exception->getCode());
        }
    }

    public function logout(): JsonResponse
    {
        $data = app(LogoutAction::class)->execute();

        return response()->json($data);
    }

    public function myProfile(): JsonResponse
    {
        $data = app(MyProfileAction::class)->execute();

        return response()->json($data);
    }
}
