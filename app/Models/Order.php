<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class,'updated_by');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class,'status_id');
    }

    public function assignTo()
    {
        return $this->belongsTo(User::class,'assigned_user');
    }

    public function shipping()
    {
        return $this->belongsTo(ShippingRole::class,'shipping_method');
    }

    public function ostate()
    {
        return $this->hasOne(LocationState::class,'id','state');
    }
}
