<?php

namespace App\Http\Resources;

use App\Models\Products;
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
            'product_name' => $this->product_name,
            'product_price' => $this->product_price,
            'quantity' => $this->quantity,
            'ship_from_address' => $this->ship_from_address,
            'ship_to_address' => $this->ship_to_address,
            'shipping_fee' => $this->shipping_fee,
            'order_total_price' => $this->order_total_price,
            'status' => $this->status,
            'order_status' => $this->order_status,
            'product_Details' => Products::findOrFail($this->product_id),
        ];
    }
}