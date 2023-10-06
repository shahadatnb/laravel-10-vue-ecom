<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    public function taxonomy(){
        return $this->belongsToMany(Taxonomy::class, 'post_tax','post_id', 'tax_id');
    }

    public function postMeta()
    {
        return $this->hasMany(Postmeta::class);
    }

    
    public function price(){
        $old_price = $this->hasMany(Postmeta::class)->where('meta_key','price')->pluck('meta_value')->first();
        $reduced_price = $this->hasMany(Postmeta::class)->where('meta_key','reduced_price')->pluck('meta_value')->first();
        if($reduced_price > 0){
            $price = $reduced_price;
        }else{
            $price = $old_price;
        }
        return $price;
    }

/*     public function setTitleAttribute($value){
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $this->postSlug($value);
    }

    private function postSlug($slug){
        $slug = Str::slug($slug, '-'); 
        $count = Post::where('slug','like',$slug.'%')->count();
        $suffix = $count ? $count+1 : '';
        $slug .= $suffix;
        return $slug;
    } */
}
