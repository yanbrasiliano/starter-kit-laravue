<?php

namespace App\Http\Controllers\API;

use App\Actions\Role\{CreateRoleAction, ListRoleAction, ShowRoleAction, UpdateRoleAction};
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\IndexRoleRequest;
use App\Http\Requests\Role\{CreateRoleRequest, UpdateRoleRequest};
use App\Http\Resources\RoleResource;
use App\Services\Role\RoleService;
use App\Traits\LogsActivityTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\{JsonResponse};
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    use LogsActivityTrait;

    public function __construct(
        private RoleService $service
    ) {
    }

    /**
     * @route GET /api/v1/roles
     * @title Lista os perfis
     * @description Lista todos os perfis cadastrados no sistema
     * @tags Perfis
     * @queryParam limit integer Quantidade de itens por página
     * @queryParam page integer Número da página
     * @queryParam order string Ordem de exibição dos itens [asc, desc]
     * @queryParam column string Coluna a ser utilizada para realizar a ordenação
     * @queryParam name string Nome do perfil
     * @queryParam description string Descrição
     * @response 200 OK
     * @response 401 Usuário não autenticado
     * @response 403 Usuário não tem permissão de acesso
     * @security bearerAuth
     */
    public function index(IndexRoleRequest $request, ListRoleAction $action): JsonResource
    {
        $roles = $action->execute($request->fluent()->validated());

        return RoleResource::collection($roles);
    }

    /**
     * @route POST /api/v1/roles
     * @title Cadastra perfis
     * @description Cadastra novos perfis na plataforma
     * @tags Perfis
     * @bodyParam name string required Nome do perfil
     * @bodyParam description string required Descrição
     * @bodyParam permissions array Permissões
     * @response 200 OK
     * @response 401 Usuário não autenticado
     * @response 403 Usuário não tem permissão de acesso
     * @security bearerAuth
     */
    public function store(CreateRoleRequest $request, CreateRoleAction $action): JsonResource
    {
        $role = $action->execute($request->fluent()->validated());

        return new RoleResource($role);
    }

    /**
     * @route GET /api/v1/roles/{id}
     * @title Consulta os dados do perfil cadastrado
     * @description Consulta com mais detalhes os dados do perfil
     * @tags Perfis
     * @pathParam id integer required ID do perfil cadastrado
     * @response 200 OK
     * @response 401 Usuário não autenticado
     * @response 403 Usuário não tem permissão de acesso
     * @response 404 Perfil não encontrado
     * @security bearerAuth
     */
    public function show(Role $role): JsonResource
    {

        $roleWithPermissions = (new ShowRoleAction())->execute($role);
        $this->logGeneralActivity('Gestão de Perfis', $role, 'Visualizou os detalhes do perfil');

        return new RoleResource($roleWithPermissions);
    }

    /**
     * @route PUT /api/v1/roles/{id}
     * @title Atualiza os dados do perfil
     * @tags Perfis
     * @pathParam id integer required ID do perfil cadastrado
     * @bodyParam name string required Nome do perfil
     * @bodyParam description string required Descrição
     * @bodyParam permissions array Permissões
     * @response 200 OK
     * @response 401 Usuário não autenticado
     * @response 403 Usuário não tem permissão de acesso
     * @response 404 Perfil não encontrado
     * @security bearerAuth
     */
    public function update(UpdateRoleRequest $request, Role $role, UpdateRoleAction $action): JsonResource
    {
        $this->authorize('update', $role);

        $updatedRole = $action->execute($role, $request->fluent()->validated());

        return new RoleResource($updatedRole);
    }

    /**
     * @route DELETE /api/v1/roles/{id}
     * @title Remove Perfis cadastrados
     * @description Remove informações de Perfis cadastrados
     * @tags Perfis
     * @pathParam id integer required ID do Perfil cadastrado
     * @response 204 No Content
     * @response 401 Usuário não autenticado
     * @response 403 Usuário não tem permissão de acesso
     * @response 404 Perfil não encontrado
     * @security bearerAuth
     */
    public function destroy(Role $role): JsonResponse
    {
        $this->authorize('delete', $role);

        $deleted = $this->service->delete($id);

        if ($deleted) {
            $this->logDeleteActivity('Gestão de Perfis', $role, 'Excluiu um perfil');

            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        return response()->json(['message' => 'Não foi possível realizar essa ação'], Response::HTTP_NOT_MODIFIED);
    }

    /**
     * @route GET /api/v1/roles/list-all
     * @title Lista todos os perfis cadastrados
     * @description Retorna perfis cadastrados
     * @tags Perfis
     * @response 200 OK
     * @response 401 Usuário não autenticado
     * @security bearerAuth
     */
    public function listAll(): JsonResource
    {
        $roles = $this->service->listAll();

        return RoleResource::collection($roles);
    }
}
