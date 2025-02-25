<?php

namespace App\Http\Controllers\Api\User;

use App\Actions\User\{CreateExternalUserAction, CreateUserAction, ListUserAction};
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateUserRequest, IndexUserRequest, RegisterExternalUserRequest, UpdateUserRequest};
use App\Http\Resources\UserResource;
use App\Services\User\UserService;
use App\Traits\LogsActivityTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\{JsonResponse, Request};
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use LogsActivityTrait;

    public function __construct(
        private UserService $service
    ) {
    }

    public function index(IndexUserRequest $request, ListUserAction $action): JsonResource
    {
        $users = $action->execute($request->fluent()->validated());

        return new UserResource($users);
    }

    public function store(CreateUserRequest $request, CreateUserAction $action): JsonResource
    {
        $user = $action->execute($request->fluent()->validated());

        return new UserResource($user);
    }

    public function show(int $id): JsonResource
    {
        $user = $this->service->getById($id);

        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, int $id): JsonResource
    {
        [$user] = $this->service->getModelAndDTOById($id);

        $updateUserDTO = $request->toDTO();

        $updatedUserDTO = $this->service->update($id, $updateUserDTO);

        $this->logUpdateActivity('Gestão de Usuários', $user, $request->validated(), 'Atualizou um usuário');

        return new UserResource($updatedUserDTO);
    }

    public function destroy(int $id, Request $request): Response
    {
        [$user] = $this->service->getModelAndDTOById($id);
        $reason = $request->input('reason');

        $this->logDeleteActivity('Gestão de Usuários', $user, 'Excluiu um usuário');

        $this->service->delete($id, $reason);

        return response([], Response::HTTP_NO_CONTENT);
    }

    public function register(RegisterExternalUserRequest $request, CreateExternalUserAction $action): JsonResponse
    {
        $user = $action->execute($request->fluent()->validated());

        return response()->json([
            'message' => "Um e-mail de confirmação foi encaminhado para {$user->email}. Por favor, realize os procedimentos para ativação da sua conta.",
        ], Response::HTTP_OK);
    }

    public function verify(Request $request): JsonResponse
    {
        $this->service->verify(
            $request->id
        );

        return response()->json([
            'message' => 'O seu cadastro foi verificado com sucesso!',
        ], Response::HTTP_OK);
    }
}
