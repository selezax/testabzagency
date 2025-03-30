<?php

namespace TestImgApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCollectionResource extends JsonResource
{
    public function toArray($request)
    {
        $count = $this->resource->perPage();
        $baseUrl = $request->url();

        return [
            'success' => true,
            'page' => $this->resource->currentPage(),
            'total_pages' => $this->resource->lastPage(),
            'total_users' => $this->resource->total(),
            'count' => $count,
            'links' => [
                'next_url' => $this->resource->hasMorePages() ? "{$baseUrl}?page=" . ($this->resource->currentPage() + 1) . "&count={$count}" : null,
                'prev_url' => $this->resource->onFirstPage() ? null : "{$baseUrl}?page=" . ($this->resource->currentPage() - 1) . "&count={$count}",
            ],
            'users' => UserItemResource::collection($this->resource->items()),
        ];
    }
}
