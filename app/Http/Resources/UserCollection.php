<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @OA\Schema(schema="User")
 * {
 *   @OA\Property(property="id", type="integer", example="id"),
 *   @OA\Property(property="name", type="string", example="name"),
 *   @OA\Property(property="email", type="string", example="email"),
 */
class UserCollection extends JsonResource
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
            'email' => $this->email,
        ];
    }
}

