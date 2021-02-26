<?php

namespace App\Http\Controllers\joyCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JoyCenterController extends Controller
{
    public function index (){
        return view("joyCenter/home");

    }
    public function patient(){
        return view("joyCenter/patient");
    }
    public function queue(){
        return view("joyCenter/queue");
    }
    public function consultation(){
        return view("joyCenter/consultation");
    }
    public function patientSearch(){
        return view("joyCenter/patientSearch");
    }
}
