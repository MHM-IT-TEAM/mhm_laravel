<?php

namespace App\Http\Controllers\medical\obstetrics;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Ultrasound;
use Illuminate\Http\Request;

class UltraSoundController extends Controller
{

    private $ultrasound;
    private $consultation;

    /**
     * UltraSoundController constructor.
     * @param $ultrasound
     */
    public function __construct()
    {
        $this->ultrasound = new Ultrasound();
        $this->consultation= new Consultation();
    }

    public function index()
    {
        return $this->consultation->where('type_consult_id',5)->whereDate('created_at', '=', date('Y-m-d'))->with(['patient','vitalSigns'])->get();
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
        //
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
