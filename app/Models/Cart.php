<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'productId',
        'userId',
        'qty'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'productId','id');
    }

    protected $apends=['total'];

    public function getTotalAttribute()
    {
        return $this->qty * $this->product->price;
    }

}
