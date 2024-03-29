<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'color_id' => $this->color_id,
            'color' => $this->color? $this->color->name : null,
            'size_id' => $this->size_id,
            'size' => $this->size? $this->size->name : null,
            'price' => $this->price,
            'reduced_price' => $this->reduced_price,
            'quantity' => $this->quantity
        ];
    }
}
