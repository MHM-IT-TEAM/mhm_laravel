<?php

namespace App\Http\Controllers\V1\patient_system\in_patient\stork_center;

use App\Http\Controllers\Controller;
use App\Models\StorkComment;
use Illuminate\Http\Request;

class StorkCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
//        dd($request->all());
        StorkComment::create([
            'stork_admission_id'=>$request->stork_admission_id,
            'comment'=>$request->comment,
            'user_id'=>$request->user_id
        ]);
        return StorkComment::with('user')->where('stork_admission_id',$request->stork_admission_id)->orderByDesc('created_at')->get();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return StorkComment::with('user')->where('stork_admission_id',$id)->orderByDesc('created_at')->get();

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
        StorkComment::find($id)->delete();
    }

    public function update_showInProjection($id, $showInProjection){
        $comment= StorkComment::find($id);
        $comment->show_in_projection = $showInProjection=='true'? 1 : 0;
        $response = $comment->save();
    }
}
