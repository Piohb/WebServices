<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @OA\Schema(schema="User")
 * {
 *   @OA\Property(property="name", type="string", example="name"),
 *   @OA\Property(property="email", type="string", example="email"),
 *   @OA\Property(property="password", type="string", example="password"),
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
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
