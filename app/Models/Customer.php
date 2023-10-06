<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; // for auth
use Illuminate\Foundation\Auth\User as Authenticatable; // for auth
use App\Notifications\CustomerResetPasswordNotification;

class Customer extends Authenticatable
{
    use Notifiable; // for auth
    protected $guard = 'customer'; // for auth

    protected $fillable = [
        'name','address','address2','state','city','postcode','phone','email','password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
    $this->notify(new CustomerResetPasswordNotification($token));
    }
    
    public function wishlist(){
        return $this->hasMany(WishList::class,'customer_id');
    }

    public function orders(){
        return $this->hasMany(Order::class,'customer_id');
    }

    public function ostate(){
        return $this->belongsTo(LocationState::class,'state');
    }
}
