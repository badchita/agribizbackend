<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Addresses;
use App\Models\ProductRatings;
use App\Models\User;

class ProductsResources extends JsonResource
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
            'user_id' => $this->user_id,
            'seller' => User::findOrFail($this->user_id),
            'addresses_detail' => Addresses::findOrFail($this->product_location_id),
            'addresses' => AddressesResources::collection($this->whenLoaded('addresses')),
            'product_ratings' => ProductRatingResources::collection($this->whenLoaded('product_ratings')),
        ];
    }
}
