<?php

namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @OA\Schema(
 *   title="Retorno de paginação",
 *   type="object",
 * )
 */
class CustomPaginator extends LengthAwarePaginator
{
    /**
     * @OA\Property(property="meta", type="object",
     *   @OA\Property(property="current_page", type="integer", example=1),
     *   @OA\Property(property="first_page_url", type="string", example="http://localhost:8000/api/modelo?page=1"),
     *   @OA\Property(property="from", type="integer", example=1),
     *   @OA\Property(property="last_page", type="integer", example=1),
     *   @OA\Property(property="last_page_url", type="string", example="http://localhost:8000/api/modelo?page=1"),
     *   @OA\Property(property="next_page_url", type="string", example=null),
     *   @OA\Property(property="path", type="string", example="http://localhost:8000/api/modelo"),
     *   @OA\Property(property="per_page", type="integer", example=15),
     *   @OA\Property(property="prev_page_url", type="string", example=null),
     *   @OA\Property(property="to", type="integer", example=3),
     *   @OA\Property(property="total", type="integer", example=3),
     * ),
     * @OA\Property(property="links", type="array",
     *   @OA\Items(type="object",
     *       @OA\Property(property="url", type="string", example="http://localhost:8000/api/modelo?page=1"),
     *       @OA\Property(property="label", type="string", example="1"),
     *       @OA\Property(property="active", type="boolean", example=true),
     *   ),
     * ),
     */
    public function toArray(): array
    {
        return [
            'data' => $this->items->toArray(),
            'meta' => [
                'current_page' => $this->currentPage(),
                'first_page_url' => $this->url(1),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'last_page_url' => $this->url($this->lastPage()),
                'next_page_url' => $this->nextPageUrl(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'prev_page_url' => $this->previousPageUrl(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ],
            'links' => $this->withQueryString()->linkCollection(),
        ];
    }
}
