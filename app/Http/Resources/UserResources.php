<?php

namespace App\Http\Resources;

use App\Models\Addresses;
use App\Models\Orders;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'birthday' => $this->birthday,
            'mobile' => $this->mobile,
            'user_type' => $this->user_type,
            'joined_date' => $this->joined_date,
            'username' => $this->username,
            'address_id' => $this->address_id,
            'isOnline' => $this->isOnline,
            'status' => $this->status,
            'orders' => Orders::select('*')->where('user_id', $this->id)->get(),
            'selected_address' => Addresses::find($this->address_id),
            'addresses' => AddressesResources::collection($this->whenLoaded('addresses')),
            'products' => ProductsResources::collection($this->whenLoaded('products')),
        ];
    }
}