<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index( Request $request){

        $source= [
            'name'=>'tiavina',
            'adress'=>'Tana'
        ];
        dd(auth()->id());
    }
}
