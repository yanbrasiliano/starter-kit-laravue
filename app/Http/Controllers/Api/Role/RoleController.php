<?php

namespace App\Http\Controllers\Api\Role;

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
    public function index(IndexRoleRequest $request): JsonResource
    {
        $this->authorize('index', Role::class);

        $roles = app(ListRoleAction::class)->execute($request->fluent()->validated());

        return RoleResource::collection($roles);
    }

    public function store(CreateRoleRequest $request): JsonResource
    {
        $this->authorize('store', Role::class);

        $role = app(CreateRoleAction::class)->execute($request->fluent()->validated());

        return new RoleResource($role);
    }

    public function show(Role $role): JsonResource
    {
        $this->authorize('show', $role);

        $roleWithPermissions = app(ShowRoleAction::class)->execute($role);

        return new RoleResource($roleWithPermissions);
    }

    public function update(UpdateRoleRequest $request, Role $role): JsonResource
    {
        $this->authorize('update', $role);

        $updatedRole = app(UpdateRoleAction::class)->execute($role, $request->fluent()->validated());

        return new RoleResource($updatedRole);
    }

    public function destroy(Role $role): JsonResponse
    {
        try {
            $this->authorize('delete', $role);

            $deleted = app(DeleteRoleAction::class)->execute($role);

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
        $roles = app(ListAllRoleAction::class)->execute();

        return RoleResource::collection($roles);
    }
}
