<?php

namespace App\Exports;

use App\Models\Surgery;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

class SurgeryExport implements WithHeadings,FromQuery,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            '#',
            'Type surgery',
            'Date',
            'Time surgery',
            'Time end surgery',
            'admission_id',
            'patient_id',
            'First name',
            'Last name',
            'Birth Date',
            'Address',
            'Tel',
            'Reason for surgery',
            'comment',
            'emla_on',
            'emla_off',
            'weight',
            'temp',
            'pulse',
            'taSysto',
            'taDia',
            'spo2',
            'surgery_report',
            'dismissal_outcome',
            'wound_care',
            'wound_care_date',
            'next_surgery',
            'next_surgery_date',
            'appointment_for_followup',
            'surgeons',
            'doctors',
            'anesthetists',
            'midwives',
            'nurses',
            'other_people',
            'status'
        ];
    }
//    public function collection()
//    {
//        return Surgery::all();
//    }
    public function query()
    {
        return Surgery::with('patient');
    }
    public function map($surg): array
    {
        return [
            $surg->id,
            $surg->type_of_surgery,
            $surg->date_of_surgery,
            $surg->time_surgery,
            $surg->time_is_surgery_finished,
            $surg->admission_id,
            $surg->patient_id,
            $surg->patient->firstName,
            $surg->patient->lastName,
            $surg->patient->BirthDate,
            $surg->patient->Address,
            $surg->patient->Tel,
            $surg->reason_for_surgery,
            $surg->comment,
            $surg->emla_on,
            $surg->emla_off,
            $surg->weight,
            $surg->temp,
            $surg->pulse,
            $surg->taSysto,
            $surg->taDia,
            $surg->spo2,
            $surg->surgery_report,
            $surg->dismissal_outcome,
            $surg->wound_care,
            $surg->wound_care_date,
            $surg->next_surgery,
            $surg->next_surgery_date,
            $surg->appointment_for_followup,
            $surg->surgeons,
            $surg->doctors,
            $surg->anesthetists,
            $surg->midwives,
            $surg->nurses,
           $surg->other_people,
            $surg->status
        ];
    }
}
