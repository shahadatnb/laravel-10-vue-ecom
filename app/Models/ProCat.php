<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProCat extends Model
{
    protected $fillable = [ 'title', 'description','photo','status'];

    public function products(){
        return $this->belongsToMany(Product::class,'product_category','category_id','product_id');
    }
}
