<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRole extends Model
{
    public function state(){
        return $this->belongsTo(LocationState::class,'location_id');
    }
}
