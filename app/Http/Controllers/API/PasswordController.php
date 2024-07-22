<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Password\{ForgotPasswordRequest, ResetPasswordRequest};
use App\Services\Password\PasswordService;
use Illuminate\Http\{JsonResponse, Response};

class PasswordController extends Controller
{
    public function __construct(protected PasswordService $service)
    {
        $this->service = $service;
    }

    /**
     * @route POST /api/v1/forgot-password
     * @tags Password
     * @title Password recovery request
     * @description Pass user credentials
     * @bodyParam email string required The user's email address
     * @response 204 No Content
     * @response 422 Failure to validate submitted data
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $this->service->forgotPassword($request->validated());

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @route POST /api/v1/reset-password
     * @tags Password
     * @title Password recovery
     * @description Pass user credentials
     * @bodyParam email string required The user's email address
     * @bodyParam token string required The password reset token
     * @bodyParam password string required The new password
     * @bodyParam password_confirmation string required Password confirmation
     * @response 204 No Content
     * @response 422 Failure to validate submitted data
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $this->service->resetPassword($request->validated());

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
