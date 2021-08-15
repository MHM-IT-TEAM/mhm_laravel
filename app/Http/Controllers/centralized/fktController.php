<?php

namespace App\Http\Controllers\centralized;

use App\Http\Controllers\Controller;
use App\Models\Fokontany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class fktController extends Controller
{
    public function index(){
        return  Fokontany::all();
    }
}
