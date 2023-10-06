<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [ 'title', 'price','weight','reduced_price','brand_id','featured','description','status','user_id','photo']; 	 	
    // public function cat(){
    // 	return $this->hasOne('App\ProCat','id','cat_id');
    // }
    public function categories(){
    	return $this->belongsToMany(ProCat::class,'product_category','product_id','category_id');
    }

    public function price(){
        $old_price = $this->price;
        $reduced_price = $this->reduced_price;
        if($reduced_price > 0){
            $price = $reduced_price;
        }else{
            $price = $old_price;
        }
        return $price;
    }

    public function galleries(){
        return $this->hasMany(Attachment::class,'product_id','id');
    }
    
}
