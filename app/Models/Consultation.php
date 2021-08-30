<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
    protected $connection='patSyst';
    protected $guarded=[];
    //relationships
        public function patient(){
            return $this->belongsTo(Patient::class);
        }
        public function typeConsult(){
            return $this->belongsTo(ConsultationType::class);
        }
        public function vitalSigns(){
            return $this->hasOne(VitalSign::class);
        }
        public function patientCareDetails(){
            return $this->hasMany(PatientCareDetail::class);
        }
        public function graceCsbTransaction(){
            return $this->hasMany(GraceCsbTransaction::class);
        }
    //scopes
        public function scopeTodayConsultation($query){
            return $query->whereDate('created_at',Carbon::today());
        }
        public function scopeUnpaid ($query){
            return $query->where('payment_status','UNPAID');
        }
        public function scopeBetweenDate($query,$start,$end){
            return $query->whereBetween(
                'invoices.invoice_date',
                [$start->format('Y-m-d'), $end->format('Y-m-d')]
            );
        }
        public function scopeDate($query,$date){
            return $query->where('created_at',date($date));
        }
        public function scopeMonth($query,$month){
            return $query->whereMonth('created_at',$month);
        }
        public function scopeYear($query,$year){
            return $query->whereYear('created_at',$year);
        }
        public function scopeType($query,$type){
            return $query->where('type_consult_id',$type);
        }
        public function scopeWhereTypeConsultIn($query, array $range){
            return $query->whereIn('type_consult_id',$range);
        }
        public function scopePatient($query,$patient_id){
            return $query->where('patient_id',$patient_id);
        }
    //filter
        public function applyFilters($query,array $filters){
            $filters= collect($filters);
            if($filters->get('today')){
                return $query->todayConsultation();
            }
            if($filters->get('type')){
                return $query->type($filters->get('type'));
            }
            if($filters->get('patient_id')){
                return $query->patient($filters->get('patient_id'));
            }
        }

}
