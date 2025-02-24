<?php

namespace App\Http\Controllers\Api\Auth;

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
        return response()->json($this->service->login($request->validated()));
    }

    public function logout(): JsonResponse
    {
        return response()->json([
            'message' => $this->service->logout(),
        ]);
    }

    public function myProfile(): JsonResponse
    {
        return response()->json($this->service->myProfile());
    }
}
