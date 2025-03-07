<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class userProductController extends Controller
{
    public function index()
    {
        $products= Product::getActive()->get();
        return response()->json(["data"=>$products]);
    }

    public function show(string $id)
    {
        $product=Product::findOrFail($id);
        return response()->json(["data"=>$product]);

    }

    public function search(Request $request)
    {
         $query= Product::query();

         if(request()->has('title'))
         {
             $query->where('title','LIKE',$request->title.'%')->where('qtyInStock',
            '>',0);
         }
         $products=$query->get();
         return response()->json(['data'=>$products]);
    }
}
