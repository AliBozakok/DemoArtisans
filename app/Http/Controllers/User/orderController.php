<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\orderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class orderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order=Order::where('userId',auth('user')->id());
        return orderResource::collection($order);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input= $request->validate([
            'location'=>['required'],
            'phoneNumber'=>['required']
        ]);
         DB::transaction(function () use ($input) {
        $orderId= Order::latest()->first();
        if($orderId == null)
        {
           $orderId= 1;
        }
        else
        {
           $orderId= $orderId->id  + 1;
        }

            $caartItems= Cart::where('userId',auth('user')->id())->get();
            $orderTotal= 0;
            foreach($caartItems as $item)
            {
                OrderItem::create([
                    'orderId'=>$orderId,
                    'productId'=>$item->productId,
                    'qty'=>$item->qty
                ]);
                $item->decrease();
                $orderTotal= $orderTotal + $item->total;
                $item->delete();
            }
            $wallet=$caartItems->userId->wallet;
            if($wallet<$orderTotal)
            {
                return response()->json(['message'=>'you do not have enough money in your wallet']);
            }
            Order::create([
                'userId'=>auth('user')->id(),
                'total'=>$orderTotal,
                'location'=>$input['location'],
                'phone'=>$input['phone']
            ]);
            return response()->json(["message"=>"order is created Finsh!"]);
        });

      }
}


