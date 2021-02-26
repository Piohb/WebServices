<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="Product")
 * {
 *   @OA\Property(property="name", type="string", example="name"),
 *   @OA\Property(property="description", type="text", example="description"),
 *   @OA\Property(property="category_id", type="integer", example="category_id"),
 */
class ProductCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
        ];
    }
}