<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Authenticate\AuthenticateService;

/**
 * @apiInfo
 * @title SP 2.0
 * @version 1.0.0
 * @description staterkit
 */
class AuthenticateController extends Controller
{
    public function __construct(protected AuthenticateService $service)
    {
        $this->service = $service;
    }

    /**
     * @route POST /api/v1/login
     * @tags Authentication
     * @title Logar um usuário
     * @description Pass user credentials
     * @bodyParam email string required The user's email address
     * @bodyParam password string required The user's password
     * @response 200 Success
     * @response 401 Unauthorized
     */
    public function login(LoginRequest $request)
    {
        return $this->service->login($request->validated());
    }

    /**
     * @route POST /api/v1/logout
     * @tags Authentication
     * @title Deslogar um usuário
     * @authenticated
     * @response 200 Success
     * @response 200 { "message": "Logout feito com sucesso!" }
     */
    public function logout()
    {
        return $this->service->logout();
    }

    /**
     * @authenticated
     */
    public function myProfile()
    {
        return $this->service->myProfile();
    }
}
