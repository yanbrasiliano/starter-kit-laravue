<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Authenticate\AuthenticateService;

/**
 * @OA\Info(
 *   title="SP 2.0 ",
 *   version="1.0.0",
 *   description="staterkit",
 * )
 */
class AuthenticateController extends Controller
{
    public function __construct(protected AuthenticateService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     tags={"Authentication"},
     *     summary="Logar um usuário",
     *     operationId="login",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *
     *         @OA\JsonContent(
     *             required={"email","password"},
     *
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="user", type="object"),
     *             @OA\Property(property="access_token", type="string")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        return $this->service->login($request->validated());
    }

    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     tags={"Authentication"},
     *     summary="Deslogar um usuário",
     *     operationId="logout",
     *     security={{ "apiAuth": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Logout feito com sucesso!")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        return $this->service->logout();
    }

    /**
     * @OA\Get(
     *     path="/api/v1/auth/me",
     *     tags={"Authentication"},
     *     summary="Gets information from the logged-in user",
     *     operationId="me",
     *     security={{ "apiAuth": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *     )
     * )
     */
    public function myProfile()
    {
        return $this->service->myProfile();
    }
}
