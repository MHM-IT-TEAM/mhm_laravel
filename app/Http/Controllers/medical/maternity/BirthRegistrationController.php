<?php

namespace App\Http\Controllers\medical\maternity;

use App\Http\Controllers\Controller;
use App\Models\Birth;
use App\Models\BirthAdminData;
use Illuminate\Http\Request;

class BirthRegistrationController extends Controller
{

    public function index()
    {
        return Birth::deliveryBook();
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
       //register the birth main data
        return Birth::createBirth($request);
    }


    public function show($id)
    {

        return Birth::with(['BirthAdminData','patient','birthMedicalDataBabies','birthMedicalDataMoms'])->where('code',$id)->first();
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    public function birth_certificate(Request $request, $id){
        BirthAdminData::find($id)->update($request->except(['code','birth_date','birth_time']));
        return response()->json(['success'=>true]);
    }
    public function last_birth_code(){
        $birth=Birth::latest()->first();
        if($birth)return $birth->code;
        else return '2021-000';
    }
}
