<?php

namespace App\Http\Controllers\V1\patient_system\out_patient\obstetrical;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Patient;
use App\Models\UltrasoundAdmission;
use App\Service\Medical\obstetrics\UltrasoundService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UltraSoundControllerOriginal extends Controller
{

    private $ultrasound_admission;
    private $ultrasound_service;
    private $admission;

    /**
     * UltraSoundController constructor.
     * @param $ultrasound
     */
    public function __construct(Request $request)
    {
        $this->ultrasound_admission= new UltrasoundAdmission();
        $this->admission= new Admission();
        $this->ultrasound_service= new UltrasoundService();
    }

    public function index()
    {
        return $this->admission->where('service_activity_id',11)
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->with(['ultraSoundAdmission', 'patient', 'vitalSigns'])
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

    public function ultrasound_id_for_admission_id_for_cpn($admission_id) {
        $admission = UltrasoundAdmission::where('admission_id_for_first_cpn', $admission_id)->first();
        if ($admission)
            return $admission->id;

        return null;
    }

    public function get_recent_ultrasound_admissions_for_patient($patient_id) {
        $patient = Patient::find($patient_id);

        $admissions = UltrasoundAdmission::with(['ultrasound_early_screenings:id,ultrasound_admission_id','ultrasound_first_screenings:id,ultrasound_admission_id','ultrasound_confirmation_of_due_date_screenings:id,ultrasound_admission_id','ultrasound_second_screenings:id,ultrasound_admission_id','ultrasound_third_screenings:id,ultrasound_admission_id','ultrasound_additional_screenings:id,ultrasound_admission_id'])
            ->where('patient_id', $patient_id)
            ->whereBetween('updated_at', [Carbon::now()->subYear(), Carbon::now()])
            ->get();

        $result = [];

        foreach($admissions as $admission) {
            array_push($result, (object)[
                'created_at' => $admission->created_at,
                'updated_at' => $admission->updated_at,
                'id' => $admission->id,
                'screening_status' => $this->get_screening_status($admission),
                'is_patient_pregnant' => $admission->is_patient_pregnant
            ]);
        }

        return [
            'patient' => $patient,
            'ultrasound_admissions' => $result
        ];
    }

    private function get_screening_status($ultrasound_admission) {
        if ($ultrasound_admission->ultrasound_third_screenings && count($ultrasound_admission->ultrasound_third_screenings) > 0) {
            if ($ultrasound_admission->ultrasound_additional_screenings && count($ultrasound_admission->ultrasound_additional_screenings) > 0) {
                $count = count($ultrasound_admission->ultrasound_additional_screenings);
                return  $count . " additional screening" . ($count == 1 ? '' : 's') . " completed";
            }

            return "Third screening completed";
        }
        if ($ultrasound_admission->ultrasound_second_screenings && count($ultrasound_admission->ultrasound_second_screenings) > 0) {
            return "Second screening completed";
        }
        if ($ultrasound_admission->ultrasound_confirmation_of_due_date_screenings && count($ultrasound_admission->ultrasound_confirmation_of_due_date_screenings) > 0) {
            return "Confirmation of due date screening completed";
        }
        if ($ultrasound_admission->ultrasound_first_screenings && count($ultrasound_admission->ultrasound_first_screenings) > 0) {
            return "First screening completed";
        }
        if ($ultrasound_admission->ultrasound_early_screenings && count($ultrasound_admission->ultrasound_early_screenings) > 0) {
            return "Early screening completed";
        }
    }
}
