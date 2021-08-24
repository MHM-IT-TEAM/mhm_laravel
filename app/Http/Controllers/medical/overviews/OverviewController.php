<?php

namespace App\Http\Controllers\medical\overviews;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OverviewController extends Controller
{

    public function index()
    {
        return view('medical.overviews.index');
    }
    public function pregnancy_card($cpn_admission){


        return [
            'first_checkup',
            'cpn_followup',
            'ultrasound',
            'blood_control'
        ];
    }
}
