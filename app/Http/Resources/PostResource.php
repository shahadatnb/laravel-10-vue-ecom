<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'image' => asset('storage/'.$this->image),
            'postMeta' => $this->postMeta->pluck('meta_value','meta_key')->toArray(), //$this->postMetas($this->postMeta),
        ];

    }
    protected function postMetas($metas){
        return $metas->pluck('meta_value','meta_key')->toArray();
    }
}
