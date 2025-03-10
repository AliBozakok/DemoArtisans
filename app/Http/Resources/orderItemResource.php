<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class orderItemResource extends JsonResource
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
             'CartQty'=> $this->qty,
             'productTitle'=>$this->product->title,
             'productPrice'=>$this->product->price];
    }
}
