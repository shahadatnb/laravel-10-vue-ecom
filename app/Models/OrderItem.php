<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id','product_id','qty_ordered','price','total',
    ];

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
