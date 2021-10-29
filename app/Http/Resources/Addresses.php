<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Addresses extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $products = $this->whenLoaded('products');
        return [
            'id' => $this->id,
            'street_building' => $this->street_building,
            'barangay' => $this->barangay,
            'city' => $this->city,
            'province' => $this->province,
            'status' => $this->status,
            'user_id' => $this->user_id,
            // 'company' => new Products($products),
        ];
    }
}