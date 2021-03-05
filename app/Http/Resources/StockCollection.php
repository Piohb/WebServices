<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="Stock")
 * {
 *   @OA\Property(property="id", type="integer", example="id"),
 *   @OA\Property(property="product_id", type="id", example="product_id"),
 *   @OA\Property(property="shop_id", type="id", example="shop_id"),
 *   @OA\Property(property="price", type="integer", example="price"),
 *   @OA\Property(property="stock", type="integer", example="stock"),
 *   @OA\Property(property="sales", type="integer", example="sales"),
 */
class StockCollection extends JsonResource
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
            'product_id' => $this->product_id,
            'shop_id' => $this->shop_id,
            'price' => $this->price,
            'stock' => $this->stock,
            'sales' => $this->sales,
        ];
    }
}