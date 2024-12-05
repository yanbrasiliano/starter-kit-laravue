<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Services\Permission\PermissionService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PermissionController extends Controller
{
    public function __construct(
        private PermissionService $service
    ) {
    }

    /**
     * @route GET /api/v1/permissions
     * @title Lista as permissoes
     * @description Lista todos as permissões cadastradas no sistema
     * @tags Permissões
     * @queryParam name string Nome da permissão
     * @queryParam description string Descrição
     * @response 200 OK
     * @response 401 Usuário não autenticado
     * @response 403 Usuário não tem permissão de acesso
     * @security bearerAuth
     */
    public function index(): AnonymousResourceCollection
    {
        $permissions = $this->service->index();

        return PermissionResource::collection($permissions);
    }
}
