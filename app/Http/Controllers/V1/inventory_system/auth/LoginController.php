<?php

namespace App\Http\Controllers\V1\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
        $attr = $request->validate([
            'staff_id' => 'required|integer',
            'password' => 'required|string|min:6'
        ]);
        if(!Auth::attempt($attr)){
            return response()->json([
                'msg'=>'the credential is incorrect'
            ]);
        }
    }
}
