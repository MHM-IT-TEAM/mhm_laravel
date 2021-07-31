<?php

namespace App\Http\Controllers\medical\maternity;

use App\Http\Controllers\Controller;
use App\Models\MaternityAction;
use App\Models\MaternityAdmission;
use Illuminate\Http\Request;

class MaternityActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $actions= new MaternityAction();
        $actions->create([
            'maternity_admission_id'=>$request->maternity_admission_id,
            'maternity_action_list_id'=>$request->maternity_action_list_id,
            'value'=>$request->value,
            'action_date'=>$request->action_date,
            'action_time'=>$request->action_time,
            'responsible'=>$request->responsible
        ]);
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return MaternityAdmission::with(['maternityActions'=>function($data){
            return $data->with('MaternityActionList')->get();
        }])->find($id);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
