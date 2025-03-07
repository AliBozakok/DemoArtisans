<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable =[
     'title',
     'description',
     'price',
     'qtyInstock',
     'categoryId',
     'imgUrl'
    ];

  public function category()
  {
    return $this->belongsTo(Category::class,'categoryId','id');
  }

public function scopeGetActive()
{
    return $this->where('qtyInStock','>',0);
}
}
