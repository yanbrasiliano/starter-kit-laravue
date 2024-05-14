<?php

namespace App\Http\Controllers\API;

use App\DTO\Paginate\PaginateParamsDTO;
use App\DTO\ThematicArea\CreateThematicAreaDTO;
use App\DTO\ThematicArea\UpdateThematicAreaDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ThematicArea\CreateThematicAreaRequest;
use App\Http\Requests\ThematicArea\UpdateThematicAreaRequest;
use App\Http\Resources\ThematicAreaResource;
use App\Services\ThematicArea\ThematicAreaService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ThematicAreaController extends Controller
{
    public function __construct(
        private ThematicAreaService $service
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/thematic_areas",
     *     summary="Lista as áreas temáticas",
     *     description="Lista todas as áreas temáticas cadastradas no sistema",
     *     tags={"thematic_areas"},
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
     *      name="search",
     *      in="query",
     *      required=false,
     *      description="Buscar por valor",
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
    public function index(Request $request): JsonResource
    {
        $thematicAreas = $this->service->index(
            new PaginateParamsDTO(...$request->toArray())
        );

        return ThematicAreaResource::collection($thematicAreas);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/thematic_areas",
     *     summary="Cadastra áreas temáticas",
     *     description="Cadastra novas áreas temáticas na plataforma",
     *     tags={"thematic_areas"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"description"},
     *
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Descrição",
     *                 example="Test",
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
    public function store(CreateThematicAreaRequest $request): JsonResource
    {
        $thematicArea = $this->service->create(
            new CreateThematicAreaDTO(...$request->toArray())
        );

        return new ThematicAreaResource($thematicArea);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/thematic_areas/{id}",
     *     summary="Consulta os dados da área temática cadastrada",
     *     description="Consulta com mais detalhes os dados da área temática",
     *     tags={"thematic_areas"},
     *
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="ID da área temática cadastrada",
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
     *         description="Usuário não encontrado",
     *     ),
     *
     *     security={{ "bearerAuth": {} }},
     * )
     */
    public function show(int $id): JsonResource
    {
        $thematicArea = $this->service->getById($id);

        return new ThematicAreaResource($thematicArea);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/thematic_areas/{id}",
     *     summary="Atualiza os dados da área temática",
     *     description="",
     *     tags={"thematic_areas"},
     *
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID da área temática cadastrada",
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
     *             required={"description"},
     *
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Descrição",
     *                 example="Test",
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
     *         description="Usuário não encontrado",
     *     ),
     *
     *     security={{ "bearerAuth": {} }},
     * )
     */
    public function update(UpdateThematicAreaRequest $request, int $id): JsonResource
    {
        $thematicArea = $this->service->update($id, new UpdateThematicAreaDTO(...$request->toArray()));

        return new ThematicAreaResource($thematicArea);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/thematic_areas/{id}",
     *     summary="Remove áreas temáticas cadastradas",
     *     description="Remove informações de áreas temáticas cadastradas",
     *     tags={"thematic_areas"},
     *
     *  @OA\Parameter(
     *      name="id",
     *      in="path",
     *      description="ID da área temática cadastrada",
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
     *         description="Usuário não encontrado",
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
