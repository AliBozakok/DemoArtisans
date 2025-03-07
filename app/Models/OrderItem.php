<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'productId',
        'orderId',
        'qty'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class,'productId','id');
    }


}
