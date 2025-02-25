<?php

namespace App\Http\Controllers\Api\User;

use App\Actions\User\{CreateExternalUserAction, CreateUserAction, DeleteUserAction, ListUserAction, ShowUserAction, UpdateUserAction};
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateUserRequest, IndexUserRequest, RegisterExternalUserRequest, UpdateUserRequest};
use App\Http\Resources\UserResource;
use App\Models\User;
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
        $users = $action->execute($request->fluent());

        return new UserResource($users);
    }

    public function store(CreateUserRequest $request, CreateUserAction $action): JsonResource
    {
        $user = $action->execute($request->fluent());

        return new UserResource($user);
    }

    public function show(User $user, ShowUserAction $action): JsonResource
    {
        $showUser = $action->execute($user);

        return new UserResource($showUser);
    }

    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $action): JsonResource
    {
        $updatedUser = $action->execute(params: $request->fluent(), user: $user);

        return new UserResource($updatedUser);
    }

    public function destroy(Request $request, User $user, DeleteUserAction $action): Response
    {

        try {
            $response = $action->execute(params: $request->fluent(), user: $user);

            if ($response) {
                return response()->json([
                    'message' => 'Usuário deletado com sucesso!',
                ], Response::HTTP_NO_CONTENT);
            }
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], $exception->getCode());
        }
        $reason = $request->input('reason');

        $this->logDeleteActivity('Gestão de Usuários', $user, 'Excluiu um usuário');

        $this->service->delete($id, $reason);

        return response([], Response::HTTP_NO_CONTENT);
    }

    public function register(RegisterExternalUserRequest $request, CreateExternalUserAction $action): JsonResponse
    {
        $user = $action->execute($request->fluent());

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
