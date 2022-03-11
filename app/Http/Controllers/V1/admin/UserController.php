<?php

namespace App\Http\Controllers\V1\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('pages')->get();
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
        User::create($this->_fill($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $user= User::find($id);
        $user->update($this->_fill($request));
    }
    private function _fill($data){
        return [
            "employee_id"=>$data->employee_id,
            "name"=>$data->name,
            "password"=>Hash::make($data->password)
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
    }
    public function update_user_page(Request $request){
        //check if exist
        $user_pages= UserPage::where('user_id',$request->user_id)->where('page_id',$request->id)->get();
        if(!$user_pages->isEmpty()){
            $row=UserPage::find($user_pages->first()->id);
            $row->delete();
        }
        if($request->checked){
            UserPage::create([
                'user_id'=>$request->user_id,
                'page_id'=>$request->id
            ]);
        }
    }
}
