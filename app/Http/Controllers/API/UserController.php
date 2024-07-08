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
  ) {
  }

  /**
   * @OA\Get(
   *     path="/api/v1/users",
   *     summary="List users",
   *     description="Lists all users registered in the system",
   *     tags={"Users"},
   *
   *  @OA\Parameter(
   *      name="limit",
   *      in="query",
   *      required=false,
   *      description="Number of items per page",
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
   *      description="Page number",
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
   *      description="Item display order [asc, desc]",
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
   *      description="Column to be used for sorting",
   *
   *      @OA\Schema(
   *        type="string"
   *      ),
   *    ),
   *
   *   @OA\Parameter(
   *      name="search",
   *      in="query",
   *      required=false,
   *      description="Search for value",
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
   *         description="Unauthenticated user",
   *     ),
   *     @OA\Response(
   *         response=403,
   *         description="User does not have access permission",
   *     ),
   *
   *     security={{ "bearerAuth": {} }},
   * )
   */
  public function index(Request $request): JsonResource
  {
    $users = $this->service->index(
      new PaginateParamsDTO(...$request->toArray())
    );

    return new UserResource($users);
  }

  /**
   * @OA\Post(
   *     path="/api/v1/users",
   *     summary="Register users",
   *     description="Register new users on the platform",
   *     tags={"Users"},
   *
   *     @OA\RequestBody(
   *         required=true,
   *
   *         @OA\JsonContent(
   *             required={"name", "email", "active", "send_random_password", "role_id"},
   *
   *             @OA\Property(
   *                 property="name",
   *                 type="string",
   *                 description="User name",
   *                 example="Test",
   *             ),
   *             @OA\Property(
   *                 property="email",
   *                 type="string",
   *                 description="User's e-mail address",
   *                 example="usuario@mail.com",
   *             ),
   *             @OA\Property(
   *                 property="cpf",
   *                 type="string",
   *                 description="User's CPF",
   *             ),
   *             @OA\Property(
   *                 property="role_id",
   *                 type="int",
   *                 description="User profile",
   *             ),
   *              @OA\Property(
   *                 property="active",
   *                 type="int",
   *                 description="User status",
   *             ),
   *              @OA\Property(
   *                 property="send_random_password",
   *                 type="int",
   *                 description="Generate the password automatically?? [true, false]",
   *             ),
   *             @OA\Property(
   *                 property="password",
   *                 type="string",
   *                 description="New user password",
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
   *         description="Unauthenticated user",
   *     ),
   *     @OA\Response(
   *         response=403,
   *         description="User does not have access permission",
   *     ),
   *
   *     security={{ "bearerAuth": {} }},
   * )
   */
  public function store(CreateUserRequest $request): JsonResource
  {
    $user = $this->service->create(
      new CreateUserDTO(...$request->toArray())
    );

    return new UserResource($user);
  }

  /**
   * @OA\Get(
   *     path="/api/v1/users/{id}",
   *     summary="Consult the registered user's data",
   *     description="Query user data in more detail",
   *     tags={"Users"},
   *
   *  @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Registered user ID",
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
   *         description="Unauthenticated user",
   *     ),
   *     @OA\Response(
   *         response=403,
   *         description="User does not have access permission",
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="User not found",
   *     ),
   *
   *     security={{ "bearerAuth": {} }},
   * )
   */
  public function show(int $id): JsonResource
  {
    $user = $this->service->getById($id);

    return new UserResource($user);
  }

  /**
   * @OA\Put(
   *     path="/api/v1/users/{id}",
   *     summary="Updates user data",
   *     description="",
   *     tags={"Users"},
   *
   *     @OA\Parameter(
   *          name="id",
   *          in="path",
   *          description="Registered user ID",
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
   *             required={"name", "email", "active", "role_id"},
   *
   *             @OA\Property(
   *                 property="name",
   *                 type="string",
   *                 description="User name",
   *                 example="Test",
   *             ),
   *             @OA\Property(
   *                 property="email",
   *                 type="string",
   *                 description="User e-mail",
   *                 example="usuario@mail.com",
   *             ),
   *             @OA\Property(
   *                 property="role_id",
   *                 type="int",
   *                 description="User profile",
   *             ),
   *              @OA\Property(
   *                 property="active",
   *                 type="int",
   *                 description="User status",
   *             ),
   *             @OA\Property(
   *                 property="password",
   *                 type="string",
   *                 description="New user password",
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
   *         description="Unauthenticated user",
   *     ),
   *     @OA\Response(
   *         response=403,
   *         description="User does not have access permission",
   *     ),
   *      @OA\Response(
   *         response=404,
   *         description="User not found",
   *     ),
   *
   *     security={{ "bearerAuth": {} }},
   * )
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
   * @OA\Delete(
   *     path="/api/v1/users/{id}",
   *     summary="Remove registered users",
   *     description="Removes information from registered users",
   *     tags={"Users"},
   *
   *  @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Registered user ID",
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
   *         description="Unauthenticated user",
   *     ),
   *     @OA\Response(
   *         response=403,
   *         description="User does not have access permission",
   *     ),
   *     @OA\Response(
   *         response=404,
   *         description="User not found",
   *     ),
   *
   *     security={{ "bearerAuth": {} }},
   * )
   */
  public function destroy(int $id, Request $request): Response
  {
    $reason = $request->input('reason');
    $this->service->delete($id, $reason);

    return response([], Response::HTTP_NO_CONTENT);
  }

  /**
   * @OA\Post(
   *     path="/api/v1/users/register",
   *     summary="Register users",
   *     description="Register new users on the platform",
   *     tags={"Users"},
   *
   *     @OA\RequestBody(
   *         required=true,
   *
   *         @OA\JsonContent(
   *             required={"name", "email", "cpf", "role", "password", "confirm_password"},
   *
   *             @OA\Property(
   *                 property="name",
   *                 type="string",
   *                 description="User name",
   *                 example="Test",
   *             ),
   *             @OA\Property(
   *                 property="email",
   *                 type="string",
   *                 description="User's e-mail address",
   *                 example="usuario@mail.com",
   *             ),
   *             @OA\Property(
   *                 property="cpf",
   *                 type="string",
   *                 description="User's CPF",
   *             ),
   *             @OA\Property(
   *                 property="role",
   *                 type="string",
   *                 description="User profile",
   *             ),
   *             @OA\Property(
   *                 property="password",
   *                 type="string",
   *                 description="New password",
   *             ),
   *             @OA\Property(
   *                 property="confirm_password",
   *                 type="string",
   *                 description="Confirm password",
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
   *         response=412,
   *         description="E-mail is already in use",
   *     ),
   *     @OA\Response(
   *         response=403,
   *         description="CPF is already in use",
   *     ),
   *
   *     security={{ "bearerAuth": {} }},
   * )
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
   * @OA\Get(
   *     path="/api/v1/users/verify/{id}",
   *     summary="Email verification",
   *     description="Checks the user's email address",
   *     tags={"Users"},
   *
   *  @OA\Parameter(
   *      name="id",
   *      in="path",
   *      description="Registered user ID",
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
   *         response=404,
   *         description="User not found",
   *     ),
   *
   *     security={{ "bearerAuth": {} }},
   * )
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
