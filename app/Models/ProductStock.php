<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;
    //use \Awobaz\Compoships\Compoships;

    protected $fillable = [
        'product_id','color_id','size_id','price','reduced_price','quantity'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function color(){
        return $this->belongsTo(Color::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }

    public function galleries(){
        //return $this->hasMany(Attachment::class,['product_id','color_id'],['product_id','color_id']);
        return $this->hasMany(Attachment::class,'product_id','product_id')->where('color_id', $this->color_id);//->where('product_id', $this->product_id);
    }
}
