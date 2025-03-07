<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class userWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $input=$request->validate([
            'email'=>['required','email']
        ]);
        $user=User::where('email',$input['email'])->get();
        $wallet=$user->wallet;
        return response()->json(['wallet of '.$input['email']=> $wallet]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input=$request->validate([
            'email'=>['required','email'],
            'amount'=>['required','numeric']
        ]);
        $user=User::where('email',$input['email'])->get();
        $user->wallet=$user->wallet+$input['amount'];
        return response()->json(['message'=>'Your wallet has been credited']);
    }


}
