<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\{CreateRoleRequest, RoleIndexRequest, UpdateRoleRequest};
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\{JsonResponse, Response};

/**
 * Summary of RoleController
 */
class RoleController extends Controller
{
    public function __construct(
        private RoleService $service
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/roles",
     *     summary="Lista os perfis",
     *     description="Lista todos os perfis cadastrados no sistema",
     *     tags={"Perfis"},
     *
     *  @OA\Parameter(
     *      name="limit",
     *      in="query",
     *      required=false,
     *      description="Quantidade de itens por página",
     *
     *      @OA\Schema(
     *        type="int"
     *      ),
     *    ),
     *
     *  @OA\Parameter(
     *      name="page",
     *      in="query",
     *      required=false,
     *      description="Número da página",
     *
     *      @OA\Schema(
     *        type="int"
     *      ),
     *    ),
     *
     *   @OA\Parameter(
     *      name="order",
     *      in="query",
     *      required=false,
     *      description="Ordem de exibição dos itens [asc, desc]",
     *
     *      @OA\Schema(
     *        type="string"
     *      ),
     *    ),
     *
     *    @OA\Parameter(
     *      name="column",
     *      in="query",
     *      required=false,
     *      description="Coluna a ser utilizada para realizar a ordenação",
     *
     *      @OA\Schema(
     *        type="string"
     *      ),
     *    ),
     *
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=false,
     *      description="Nome do perfil",
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
    public function index(RoleIndexRequest $request): JsonResource
    {
        $paginatedRoles = $this->service->index($request->validated());

        return RoleResource::collection($paginatedRoles);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/roles",
     *     summary="Cadastra perfis",
     *     description="Cadastra novos perfis na plataforma",
     *     tags={"Perfis"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"name", "description"},
     *
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Nome do perfil",
     *                 example="Administrador",
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Descrição",
     *             ),
     *             @OA\Property(
     *                 property="permissions",
     *                 type="array",
     *                 description="Permissões",
     *
     *                 @OA\Items(type="string"),
     *             ),
     *         ),
     *     ),
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
    public function store(CreateRoleRequest $request): JsonResource
    {
        $role = $this->service->create($request->validated());

        return new RoleResource($role);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/roles/{id}",
     *     summary="Consulta os dados do perfil cadastrado",
     *     description="Consulta com mais detalhes os dados do perfil",
     *     tags={"Perfis"},
     *
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="ID do perfil cadastrado",
     *
     *      @OA\Schema(
     *        type="int"
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
     *     @OA\Response(
     *         response=404,
     *         description="Perfil não encontrado",
     *     ),
     *
     *     security={{ "bearerAuth": {} }},
     * )
     */
    public function show(int $id): JsonResource
    {
        $role = $this->service->getById($id);

        return new RoleResource($role);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/roles/{id}",
     *     summary="Atualiza os dados do perfil",
     *     description="",
     *     tags={"Perfis"},
     *
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID do perfil cadastrado",
     *
     *      @OA\Schema(
     *        type="int"
     *      ),
     *    ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"name", "description"},
     *
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Nome do perfil",
     *                 example="Administrador",
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Descrição",
     *             ),
     *             @OA\Property(
     *                 property="permissions",
     *                 type="array",
     *                 description="Permissões",
     *
     *                 @OA\Items(type="string"),
     *             ),
     *         ),
     *     ),
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
     *      @OA\Response(
     *         response=404,
     *         description="Perfil não encontrado",
     *     ),
     *
     *     security={{ "bearerAuth": {} }},
     * )
     */
    public function update(UpdateRoleRequest $request): JsonResource
    {
        $role = $this->service->update($request->validated());

        return new RoleResource($role);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/roles/{id}",
     *     summary="Remove Perfis cadastrados",
     *     description="Remove informações de Perfis cadastrados",
     *     tags={"Perfis"},
     *
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="ID do Perfil cadastrado",
     *
     *      @OA\Schema(
     *        type="int"
     *      ),
     *    ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="No Content",
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
     *     @OA\Response(
     *         response=404,
     *         description="Perfil não encontrado",
     *     ),
     *
     *     security={{ "bearerAuth": {} }},
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $isDeleted = $this->service->delete($id);

        if ($isDeleted) {
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        return response()->json(['message' => 'Não foi possível realizar essa ação'], Response::HTTP_NOT_MODIFIED);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/roles/list-all",
     *     summary="Lista todos os perfis cadastrados",
     *     description="Retorna perfis cadastrados",
     *     tags={"Perfis"},
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
     *
     *     security={{ "bearerAuth": {} }},
     * )
     */
    public function listAll()
    {
        $roles = $this->service->listAll();

        return RoleResource::collection($roles);
    }
}
