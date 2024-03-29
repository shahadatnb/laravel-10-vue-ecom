<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'price' => $this->price,
            'reduced_price' => $this->reduced_price,
            'weight' => $this->weight,
            'featured' => $this->featured,
            'free_shipping' => $this->free_shipping,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'product_type' => $this->product_type,
            'quantity' => $this->quantity,
            'photo' => asset('storage/'.$this->photo),
            'categories' => $this->categories->pluck('title'),
            'galleries' => GalleryResource::collection($this->whenLoaded('galleries')),
            'variants' => VariantResource::collection($this->whenLoaded('variants')),
            'sizes' => $this->sizes->pluck('name','id') ?? [],
            'colors' => $this->colors->pluck('code','id') ?? [],
            //'galleries' => $this->galleries? $this->getGalleries($this->galleries) : [],
        ];
    }
}
