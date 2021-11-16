<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'weekly_income' => $this->weekly_income,
            'week_income' => $this->week_income,
            'yearly_income' => $this->yearly_income,
            'year_income' => $this->year_income,
            'user_id' => $this->user_id,
            'orders' => OrdersResources::collection($this->whenLoaded('orders')),
        ];
    }
}