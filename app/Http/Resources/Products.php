<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Addresses;
use App\Models\User;

class Products extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $addresses = $this->whenLoaded('addresses');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category' => $this->category,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'product_status' => $this->product_status,
            'product_location' => $this->product_location,
            'product_location_id' => $this->product_location_id,
            'thumbnail_name' => $this->thumbnail_name,
            'user' => User::findOrFail($this->user_id),
            'addresses' => Addresses::collection($this->whenLoaded('addresses')),
        ];
    }
}