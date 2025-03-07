<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class orderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'userName'=>$this->user->name,
            'userEmail'=>$this->user->email,
            'orderItems'=> orderItemResource::collection($this->orderItem),
            'Total'=>$this->total
        ];
    }
}
