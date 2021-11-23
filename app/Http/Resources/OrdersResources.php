<?php

namespace App\Http\Resources;

use App\Models\Addresses;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'ship_from_address_id' => $this->ship_from_address_id,
            'order_number' => $this->order_number,
            'product_total_price' => $this->product_total_price,
            'quantity' => $this->quantity,
            'ship_to_address_id' => $this->ship_to_address_id,
            'order_total_price' => $this->order_total_price,
            'status' => $this->status,
            'order_status' => $this->order_status,
            'seller_id' => $this->seller_id,
            'product_details' => Products::find($this->product_id),
            'seller_details' => User::find($this->seller_id),
            'ship_from_address_details' => Addresses::find($this->ship_from_address_id),
            'ship_to_address_details' => Addresses::find($this->ship_to_address_id),
        ];
    }
}
