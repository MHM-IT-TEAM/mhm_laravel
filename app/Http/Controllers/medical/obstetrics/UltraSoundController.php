<?php

namespace App\Http\Controllers\medical\obstetrics;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\UltrasoundAdmission;
use App\Service\Medical\obstetrics\UltrasoundService;
use Illuminate\Http\Request;

class UltraSoundController extends Controller
{

    private $ultrasound_admission;
    private $ultrasound_service;
    private $consultation;

    /**
     * UltraSoundController constructor.
     * @param $ultrasound
     */
    public function __construct(Request $request)
    {
        $this->ultrasound_admission= new UltrasoundAdmission();
        $this->consultation= new Consultation();
        $this->ultrasound_service= new UltrasoundService();
    }

    public function index()
    {
        return $this->consultation->where('type_consult_id',5)
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->with(['patient'=>function($query){
                        return $query->with(['ultraSoundAdmissions'=>function($data){
                            return $data->latest();
                        }]);
                        }, 'vitalSigns'
            ])
            ->get();
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
        return $this->ultrasound_service->store($request);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->ultrasound_service->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
