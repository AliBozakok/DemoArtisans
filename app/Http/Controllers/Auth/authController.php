<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    public function login(Request $request)
    {
       $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
       ]);

       $guard = $this->getGuard($credentials['email']); // Determine guard based on type

       if (Auth::guard($guard)->attempt(['email' => $credentials['email'], 'password' => $credentials['password']]))
        {
         $user = Auth::guard($guard)->user();
         $token = $user->createToken('auth_token', [$guard])->plainTextToken;

         return response()->json(['token' => $token, 'user' => $user, 'role' =>  $guard], 200);
        }

      return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
    if ($user) {
        $user->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }}


    public function profile(Request $request)
    {
        $user = $request->user();
        if ($user) {
            return response()->json(['user' => $user]);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    private function getGuard($email) {

        if(str_starts_with($email, 'admin-'))
        {
          return 'admin';
        }

        if(str_starts_with($email, 'Employee'))
        {
          return 'employee';
        }

        return 'user';

      }
}
