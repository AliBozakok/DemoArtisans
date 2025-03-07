<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable= [
        'userId',
        'total',
        'phoneNumber',
        'location'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'userId','id');
    }


    public function orderItem()
    {
        return $this->hasMany(OrderItem::class,'orderId','id');
    }
}
