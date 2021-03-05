<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="Shop")
 * {
 *   @OA\Property(property="id", type="integer", example="id"),
 *   @OA\Property(property="name", type="string", example="name"),
 *   @OA\Property(property="address_line", type="string", example="address_line"),
 *   @OA\Property(property="zipcode", type="string", example="zipcode"),
 *   @OA\Property(property="city", type="string", example="city"),
 *   @OA\Property(property="country", type="string", example="country"),
 */
class ShopCollection extends JsonResource
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
            'id'=> $this->id,
            'name' => $this->name,
            'address_line' => $this->address_line,
            'zipcode' => $this->zipcode,
            'city' => $this->city,
            'country' => $this->country
        ];
    }
}