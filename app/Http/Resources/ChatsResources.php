<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatsResources extends JsonResource
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
            'sender_id' => $this->sender_id,
            'from_id' => $this->from_id,
            'conversation_id' => $this->conversation_id,
            'from_username' => $this->from_username,
            'sender_username' => $this->sender_username,
            'new' => $this->new,
            'markRead' => $this->markRead,
            'status' => $this->status,
        ];
    }
}