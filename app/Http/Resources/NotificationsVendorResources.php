<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsVendorResources extends JsonResource
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
            'order_id' => $this->order_id,
            'address_id' => $this->address_id,
            'title' => $this->title,
            'content' => $this->content,
            'description' => $this->description,
            'subject' => $this->subject,
            'from_id' => $this->from_id,
            'to_id' => $this->to_id,
            'markRead' => $this->markRead,
            'created_at' => $this->created_at,
            'new' => $this->new,
        ];
    }
}