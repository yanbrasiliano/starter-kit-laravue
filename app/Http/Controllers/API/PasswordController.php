<?php

namespace App\Http\Controllers\API;

use App\DTO\Password\ForgotPasswordDTO;
use App\DTO\Password\ResetPasswordDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Password\ForgotPasswordRequest;
use App\Http\Requests\Password\ResetPasswordRequest;
use App\Services\Password\PasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PasswordController extends Controller
{
    public function __construct(protected PasswordService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/forgot-password",
     *     tags={"Password"},
     *     summary="Password recovery request",
     *     operationId="forgot-password",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *
     *         @OA\JsonContent(
     *             required={"email"},
     *
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="No Content",
     *
     *         @OA\JsonContent(
     *
     *         )
     *     ),
     *
     *    @OA\Response(
     *         response=422,
     *         description="Failure to validate submitted data.",
     *     )
     *
     * )
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $this->service->forgotPassword(
            new ForgotPasswordDTO(...$request->toArray())
        );

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/reset-password",
     *     tags={"Password"},
     *     summary="Password recovery",
     *     operationId="password-recovery",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *
     *         @OA\JsonContent(
     *             required={"email", "token", "password", "password_confirmation"},
     *
     *             @OA\Property(property="email",  type="string", format="email"),
     *             @OA\Property(property="token",  type="string", format="password", example="############"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="No Content",
     *
     *         @OA\JsonContent(
     *         )
     *     ),
     *
     *    @OA\Response(
     *         response=422,
     *         description="Failure to validate submitted data.",
     *     )
     *
     * )
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $this->service->resetPassword(
            new ResetPasswordDTO(...$request->toArray())
        );

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
