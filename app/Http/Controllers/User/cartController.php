<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class cartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems=Cart::where('userId',auth('user')->id())->get();
        return response()->json(['cart'=>$cartItems]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input= $request->validate([
            'productId'=>['required','numeric'],
            'qty'=>['nullable','numeric']
        ]);

       $item= Cart::where('userId',auth('user')->id())
       ->where('productId',$input['productId'])->first();
       if(!$item)
       {
          $input['userId']=auth('user')->id();
          Cart::create($input);
          return response()->json([
            'message'=>'item is added'
        ]);
       }
       $cartQty= $item->qty;
       if($cartQty > $item->product->qtyInStock)
       {
        return response()->json([
            'message'=>'quantity not available'
        ]);
       }

       $item->qty= $cartQty+1;
       $item->save();
       return response()->json([
        'message'=>'quantity is updated'
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $input=$request->validate([
            'qty'=>['nullable','numeric']
        ]);
        $item= Cart::where('userId',auth('user')->id())
        ->where('productId',$id)->firstOrFail();
       $cartQty= $item->qty + $input['qty']; //maybe error
       if($cartQty> $item->product->qtyInStock)
       {
           return response()->json(['message'=>'qty not avialable']);
       }
       $item->qty=  $cartQty;
       $item->save();
       return response()->json(['message'=>'qty is increased']);
    }

    public function remove(Request $request, string $id)
    {
        $input=$request->validate([
            'qty'=>['nullable','numeric']
        ]);
        $item= Cart::where('userId',auth('user')->id())
        ->where('productId',$id)->firstOrFail();
       $cartQty= $item->qty - $input['qty']; //maybe error
       if($cartQty<1)
       {
           return response()->json(['message'=>'incorrect qty']);
       }
       $item->qty=  $cartQty;
       $item->save();
       return response()->json(['message'=>'qty is decreased']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item= Cart::where('userId',auth('user')->id())
        ->where('productId',$id)->firstOrFail();
        $item->delete();
        return response()->json(['message'=>'item is deleted from cart']);
    }
}
