<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CredentialController extends Controller
{
    public function check(Request $request){
       $user= User::where('employee_id',$request->id)->get();
        if (Hash::check($request->password, $user[0]->password)) return ['success'=>true];
        return ['success'=>false];

    }
}
