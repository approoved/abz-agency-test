<?php

namespace App\Http\Resources;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

final class UserResourceCollection extends ResourceCollection
{
    /**
     * @param Request $request
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        $data = $this->resource->toArray();

        return [
            'success' => true,
            'page' => $data['current_page'],
            'total_pages' => $data['last_page'],
            'total_users' => $data['total'],
            'count' => $data['per_page'],
            'links' => [
                'next_url' => $data['links']['2']['url'],
                'prev_url' => $data['links']['0']['url'],
            ],
            'users' => $this->collection,
        ];
    }
}
