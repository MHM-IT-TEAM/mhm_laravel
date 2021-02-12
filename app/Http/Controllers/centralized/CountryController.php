<?php

namespace App\Http\Controllers\centralized;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CountryController extends Controller
{
    public function index(){

      return  (Storage::get("public/countries.txt"));

    }
}
