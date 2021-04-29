<?php

namespace App\Http\Controllers\medical\obstetrics;

use App\Http\Controllers\Controller;
use App\Models\PregnancyTest;
use App\Service\Medical\obstetrics\CpnAdmissionService;
use App\Models\CpnAdmission;
use App\Service\Medical\obstetrics\SearchService;
use Illuminate\Http\Request;

class ObstetricsController extends Controller
{
    private $admission;

    public function __construct()
    {
        $this->admission = new CpnAdmissionService();
    }

    public function index(){
        return view('medical.obstetrics.home');
    }
    public function store(Request $request){
        return $this->admission->store($request);
    }

    public function show($reference){
        return $this->admission->show($reference);
    }
    public function update($reference,Request $request){
        return $this->admission->update($reference,$request);
    }
    public function search (Request $request){
        $search= new SearchService();
        return $search->search($request->search);
    }
    public function storePregTest(Request $request){
        PregnancyTest::insert($request->only(['result','patient_id']));
    }
}
