<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),[ 
            'email' => 'required|min:6',
            'password' => 'required|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'  => 422,
                'message' => $validator->messages()->first(),
            ]);
        };

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'user' => $user,
                'token' => $user->createToken('User-Token')->plainTextToken
            ]);
        } else {
            return response()->json([
                'status'  => 404,
                'message' => 'Invalid credentials'
            ]);
        }
    
    }
}
