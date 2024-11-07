<?php

namespace App\Http\Controllers\API;

use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\User\{CreateUserDTO, RegisterExternalUserDTO, UpdateUserDTO};
use App\Http\Controllers\Controller;
use App\Http\Requests\User\{CreateUserRequest, RegisterExternalUserRequest, UpdateUserRequest};
use App\Http\Resources\UserResource;
use App\Services\User\UserService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\{JsonResponse, Request, Response};

class UserController extends Controller
{
  public function __construct(
    private UserService $service
  ) {}

  /**
   * @route GET /api/v1/users
   * @title List users
   * @description Lists all users registered in the system
   * @tags Users
   * @queryParam limit integer Number of items per page
   * @queryParam page integer Page number
   * @queryParam order string Item display order [asc, desc]
   * @queryParam column string Column to be used for sorting
   * @queryParam search string Search for value
   * @response 200 OK
   * @response 401 Unauthenticated user
   * @response 403 User does not have access permission
   * @security bearerAuth
   */
  public function index(Request $request): JsonResource
  {
    $users = $this->service->index(
      new PaginateParamsDTO(...$request->toArray())
    );

    return new UserResource($users);
  }

  /**
   * @route POST /api/v1/users
   * @title Register users
   * @description Register new users on the platform
   * @tags Users
   * @bodyParam name string required User name
   * @bodyParam email string required User's e-mail address
   * @bodyParam cpf string User's CPF
   * @bodyParam role_id int required User profile
   * @bodyParam active int required User status
   * @bodyParam send_random_password int required Generate the password automatically? [true, false]
   * @bodyParam password string New user password
   * @response 200 OK
   * @response 401 Unauthenticated user
   * @response 403 User does not have access permission
   * @security bearerAuth
   */
  public function store(CreateUserRequest $request): JsonResource
  {
    $user = $this->service->create(
      new CreateUserDTO(...$request->toArray())
    );

    return new UserResource($user);
  }

  /**
   * @route GET /api/v1/users/{id}
   * @title Consult the registered user's data
   * @description Query user data in more detail
   * @tags Users
   * @pathParam id integer required Registered user ID
   * @response 200 OK
   * @response 401 Unauthenticated user
   * @response 403 User does not have access permission
   * @response 404 User not found
   * @security bearerAuth
   */
  public function show(int $id): JsonResource
  {
    $user = $this->service->getById($id);

    return new UserResource($user);
  }

  /**
   * @route PUT /api/v1/users/{id}
   * @title Updates user data
   * @tags Users
   * @pathParam id integer required Registered user ID
   * @bodyParam name string required User name
   * @bodyParam email string required User's e-mail address
   * @bodyParam cpf string User's CPF
   * @bodyParam role_id int required User profile
   * @bodyParam active int required User status
   * @bodyParam password string New user password
   * @response 200 OK
   * @response 401 Unauthenticated user
   * @response 403 User does not have access permission
   * @response 404 User not found
   * @security bearerAuth
   */
  public function update(UpdateUserRequest $request, int $id): JsonResource
  {
    $user = $this->service->update(
      $id,
      new UpdateUserDTO(...$request->toArray())
    );

    return new UserResource($user);
  }

  /**
   * @route DELETE /api/v1/users/{id}
   * @title Remove registered users
   * @description Removes information from registered users
   * @tags Users
   * @pathParam id integer required Registered user ID
   * @response 204 No Content
   * @response 401 Unauthenticated user
   * @response 403 User does not have access permission
   * @response 404 User not found
   * @security bearerAuth
   */
  public function destroy(int $id, Request $request): Response
  {
    $reason = $request->input('reason');
    $this->service->delete($id, $reason);

    return response([], Response::HTTP_NO_CONTENT);
  }

  /**
   * @route POST /api/v1/users/register
   * @title Register users
   * @description Register new users on the platform
   * @tags Users
   * @bodyParam name string required User name
   * @bodyParam email string required User's e-mail address
   * @bodyParam cpf string required User's CPF
   * @bodyParam role string required User profile
   * @bodyParam password string required New password
   * @bodyParam confirm_password string required Confirm password
   * @response 200 OK
   * @response 412 E-mail is already in use
   * @response 403 CPF is already in use
   * @security bearerAuth
   */
  public function register(RegisterExternalUserRequest $request): JsonResponse
  {
    $this->service->registerExternal(
      new RegisterExternalUserDTO(...$request->validated())
    );

    return response()->json([
      'message' => 'Um e-mail de confirmação foi encaminhado. Por favor, realize os procedimentos para ativação da sua conta.',
    ], Response::HTTP_OK);
  }

  /**
   * @route GET /api/v1/users/verify/{id}
   * @title Email verification
   * @description Checks the user's email address
   * @tags Users
   * @pathParam id integer required Registered user ID
   * @response 204 No Content
   * @response 404 User not found
   * @security bearerAuth
   */
  public function verify(Request $request)
  {
    $this->service->verify(
      $request->id
    );

    return response()->json([
      'message' => 'O seu cadastro foi verificado com sucesso!',
    ]);
  }
}
