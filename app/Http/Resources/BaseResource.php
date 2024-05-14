<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * BaseResource
 *
 * Class that all resources must extend to get the pagination information
 * and rewrite the collection method
 *
 * @property mixed $preserveKeys
 */
class BaseResource extends JsonResource
{
    protected function transformKeys(array $allowedKeys, $request = null)
    {
        $resource = parent::toArray($request);

        $transformedData = [];
        foreach ($allowedKeys as $allowedKey) {
            $transformedData[\Str::camel($allowedKey)] = $resource[$allowedKey] ?? null;
        }

        return $transformedData;
    }

    public function paginationInformation($request, $paginated, $default)
    {
        $meta = collect($default['meta']);

        return [
            'pagination' => [
                'page' => $meta->get('current_page'),
                'rowsNumber' => $meta->get('total'),
                'rowsPerPage' => $meta->get('per_page'),
            ],
        ];
    }
}
