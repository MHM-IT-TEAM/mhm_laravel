<?php

namespace App\Http\Controllers\medical\maternity;

use App\Http\Controllers\Controller;
use App\Models\MedicalAppreciation;
use App\Models\MedicalAppreciationComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalAppreciationController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
         MedicalAppreciation::create(
            [
                'title'=>$request->title,
                'description'=>$request->description,
                "maternity_admission_id" => $request->maternity_admission_id,
                "user_id" => $request->user_id,
                "status"=>0
            ]
        );
         return $this->show($request->maternity_admission_id);
    }


    public function show($id)
    {
        return MedicalAppreciation::with(['medicalAppreciationComments'=>function($data){
            return $data->with('user')->get();
        },'user'])->where('maternity_admission_id',$id)->get();
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $appreciation=MedicalAppreciation::find($id);
        $appreciation->fill(
            [
                'title'=>$request->title,
                'description'=>$request->description,
            ]
        )->save();
        return $this->show($request->maternity_admission_id);
    }

    public function destroy($id)
    {
        MedicalAppreciationComment::where('medical_appreciation_id',$id)->delete();
        MedicalAppreciation::find($id)->delete();
    }
}
