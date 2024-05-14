<?php

namespace App\Http\Controllers\API;

use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\Unit\CreateUnitDTO;
use App\DTO\Unit\UpdateUnitDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Unit\CreateUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Http\Resources\UnitResource;
use App\Services\Units\UnitService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class UnitController extends Controller
{
    public function __construct(
        private UnitService $service
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/units",
     *     summary="List the units",
     *     description="Lists all the units registered in the system",
     *     tags={"Units"},
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
     *      description="Order by [asc, desc]",
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
     *      description="Search by value",
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
        $units = $this->service->index(
            new PaginateParamsDTO(...$request->toArray())
        );

        return new UnitResource($units);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/units",
     *     summary="Register units",
     *     description="Register new units on the platform",
     *     tags={"Units"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"description", "acronym"},
     *
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Unit description",
     *                 example="Test",
     *             ),
     *             @OA\Property(
     *                 property="acronym",
     *                 type="string",
     *                 description="Unit acronym",
     *                 example="test/test",
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
    public function store(CreateUnitRequest $request): JsonResource
    {
        $user = $this->service->create(
            new CreateUnitDTO(...$request->toArray())
        );

        return new UnitResource($user);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/units/{id}",
     *     summary="Consult the data of the registered unit",
     *     description="Get more details about the unit",
     *     tags={"Units"},
     *
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Unit ID",
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
     *         description="Unit not found",
     *     ),
     *
     *     security={{ "bearerAuth": {} }},
     * )
     */
    public function show(int $id): JsonResource
    {
        $unit = $this->service->getById($id);

        return new UnitResource($unit);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/units/{id}",
     *     summary="Updates unit data",
     *     description="",
     *     tags={"Units"},
     *
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Unit ID",
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
     *             required={"description", "acronym"},
     *
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Unit description",
     *                 example="Test",
     *             ),
     *             @OA\Property(
     *                 property="acronym",
     *                 type="string",
     *                 description="Unit acronym",
     *                 example="test/test",
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
     *     @OA\Response(
     *         response=404,
     *         description="Unit not found",
     *     ),
     *
     *     security={{ "bearerAuth": {} }},
     * )
     */
    public function update(UpdateUnitRequest $request, int $id): JsonResource
    {
        $unit = $this->service->update(
            $id,
            new UpdateUnitDTO(...$request->toArray())
        );

        return new UnitResource($unit);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/units/{id}",
     *     summary="Removes registered units",
     *     description="Removes information about registered units",
     *     tags={"Units"},
     *
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="Unit ID",
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
     *         description="Unit not found",
     *     ),
     *
     *     security={{ "bearerAuth": {} }},
     * )
     */
    public function destroy(int $id): Response
    {
        $this->service->delete($id);

        return response([], Response::HTTP_NO_CONTENT);
    }
}
