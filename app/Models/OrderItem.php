<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id','product_id','product_stock_id','qty_ordered','price','total',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(){
        return $this->hasOne(ProductStock::class,'id','product_stock_id');
    }
}
