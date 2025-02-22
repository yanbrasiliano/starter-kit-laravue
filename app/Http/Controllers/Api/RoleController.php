<?php

namespace App\Http\Controllers\Api;

use App\Actions\Role\{CreateRoleAction, DeleteRoleAction, ListAllRoleAction, ListRoleAction, ShowRoleAction, UpdateRoleAction};
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\{CreateRoleRequest, IndexRoleRequest, UpdateRoleRequest};
use App\Http\Resources\RoleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RoleController extends Controller
{
    public function index(IndexRoleRequest $request, ListRoleAction $action): JsonResource
    {
        $this->authorize('index', Role::class);

        $roles = $action->execute($request->fluent()->validated());

        return RoleResource::collection($roles);
    }

    public function store(CreateRoleRequest $request, CreateRoleAction $action): JsonResource
    {
        $this->authorize('store', Role::class);

        $role = $action->execute($request->fluent()->validated());

        return new RoleResource($role);
    }

    public function show(Role $role, ShowRoleAction $action): JsonResource
    {
        $this->authorize('show', $role);

        $roleWithPermissions = $action->execute($role);

        return new RoleResource($roleWithPermissions);
    }

    public function update(UpdateRoleRequest $request, Role $role, UpdateRoleAction $action): JsonResource
    {
        $this->authorize('update', $role);

        $updatedRole = $action->execute($role, $request->fluent()->validated());

        return new RoleResource($updatedRole);
    }

    public function destroy(Role $role, DeleteRoleAction $action): JsonResponse
    {
        try {
            $this->authorize('delete', $role);

            $deleted = $action->execute($role);

            if ($deleted) {
                return response()->json(
                    ['message' => 'Perfil excluido com sucesso'],
                    Response::HTTP_NO_CONTENT
                );
            }
        } catch (Throwable $exception) {
            return response()->json(
                ['message' => $exception->getMessage()],
                $exception->getCode()
            );
        }

    }

    public function listAll(): JsonResource
    {
        $roles = (new ListAllRoleAction())->execute();

        return RoleResource::collection($roles);
    }
}
