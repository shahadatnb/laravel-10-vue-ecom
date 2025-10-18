<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResourceLoop extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'price' => $this->price,
            'reduced_price' => $this->reduced_price,
            'weight' => $this->weight,
            'featured' => $this->featured,
            'free_shipping' => $this->free_shipping,
            'product_type' => $this->product_type,
            'quantity' => $this->quantity,
            'variant_id' => $this->variant_id,
            'photo' => asset('storage/'.$this->photo),
            'categories' => $this->categories->pluck('title'),
        ];
        if($this->product_type == 'simple'){
            $data['variant_id'] = $this->variants[0]->id;
            $data['quantity'] = $this->variants[0]->quantity;
        }
        return $data;
    }
}
