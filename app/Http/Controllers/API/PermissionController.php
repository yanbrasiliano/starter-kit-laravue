<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Services\PermissionService;

class PermissionController extends Controller
{
    public function __construct(
        private PermissionService $service
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/permissions",
     *     summary="Lista as permissoes",
     *     description="Lista todos as permissões cadastradas no sistema",
     *     tags={"Permissões"},
     *
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=false,
     *      description="Nome da permissão",
     *
     *      @OA\Schema(
     *        type="string"
     *      ),
     *    ),
     *
     *     @OA\Parameter(
     *      name="description",
     *      in="query",
     *      required=false,
     *      description="Descrição",
     *
     *      @OA\Schema(
     *        type="string"
     *      ),
     *    ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Usuário não autenticado",
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Usuário não tem permissão de acesso",
     *     ),
     *
     *     security={{ "bearerAuth": {} }},
     * )
     */
    public function index()
    {
        $permissions = $this->service->index();

        return new PermissionResource($permissions);
    }
}
