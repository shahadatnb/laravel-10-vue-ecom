<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
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
            'quantity' => $this->quantity,
            'photo' => asset('storage/'.$this->photo),
            'categories' => $this->categories->pluck('title'),
            'galleries' => $this->galleries? $this->getGalleries($this->galleries) : [],
        ];
    }

    protected function getGalleries($galleries){
        $galleryWithFullPath = [];
        foreach ($galleries as $gallery) {
            $galleryWithFullPath[$gallery->id] = asset('storage/'.$gallery->image);
        }
        return $galleryWithFullPath;
    }
}
