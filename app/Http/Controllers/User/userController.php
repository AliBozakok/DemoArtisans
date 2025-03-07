<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    public function register(Request $request)
    {
        $input= $request->validate([
            'name'=>['required','string'],
            'email'=>['required','email'],
            'password'=>['required','string']
        ]);
        $user= User::where('email',$input['email'])->first();
        if(!$user)
        {
            User::create($input);
            return response()->json(["message"=>" user is registered successfully"]);
        }
        return response()->json(["message"=>" user is found "]);
    }

    public function forgetPassword(Request $request)
    {
        $input = $request->validate(['email'=>['required','email']]);
        $otp= rand(1000,9999);
        $user= User::where('email',$input)->first();
        if(!$user)
        {
            return response()->json(["message"=>"user not found"]);
        }
        $user->otp= $otp;
        $user->save();
        return response()->json(["stasut"=>"success","otp"=>$otp]);
    }

    public function resetPassword(Request $request)
    {
        $input= $request->validate([
            'email'=>['required','email'],
            'otp'=>['required','numeric'],
            'newPassword'=>['required']
        ]);
        $user= User::where('email',$input['email'])->where('otp',$input['otp'])->first();
        if(!$user)
        {
            return response()->json(["message"=>"user not found"]);
        }
        $user->password=Hash::make( $input['newPassword']);
        $user->save();

        $user->otp= null;
        $user->save();
        return response()->json(["message"=>"new password is correct"]);
    }
}
