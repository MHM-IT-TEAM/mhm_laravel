<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Birth extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function birthAdminData(){
        return $this->hasMany(BirthAdminData::class);
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function birthMedicalDataBabies(){
        return $this->hasMany(BirthMedicalDataBaby::class);
    }

    public function birthMedicalDataMoms(){
        return $this->hasMany(BirthMedicalDataMom::class);
    }

    public function cpnAdmission(){
        return $this->belongsTo(CpnAdmission::class);
    }
    public function birth_mom_injuries(){
        return $this->hasMany(BirthMomInjury::class);
    }

    public static function createBirth($request){
            $patients=[];
            //get the code
            $digit= intval(substr($request->code,-3));
            //register  the infos about the baby
            foreach($request->babies as $data){
//                $code=str_pad($digit+1,3,"0",STR_PAD_LEFT);
                //update the latest cpn_admission
                $cpn= CpnAdmission::where('patient_id',$request->patient_id)->latest()->first();
                if($cpn !== null){
                    $cpn->parity =intval($cpn->parity)+1;
                    if($data['alive']==='yes'){
                        $cpn->ev=intval($cpn->ev)+1;
                    }
                    $cpn->save();
                }
                //register the main Data to Births table
                $src= $request->only(['patient_id','birth_date','birth_time','external_delivery','cpn_admission_id','code','GA','induction','induction_method','induction_reason','responsible_midwives','trainee','doctors','anesthetists','assistant_midwives','senior_midwives','user_id']);
//                $src['code']=date("Y").'-'.$code;
                $birth= Birth::create($src);
                //register the babies into the patient table
                $patient= new Patient();
                $patient->fill(
                    [
                        'firstName'=>$data['firstName'],
                        'lastName'=>$data['lastName'],
                        'birthDate'=>$request['birth_date'],
                        'gender'=>$data['gender'],
                        'birthPlace'=>'CH MHM Ambovo Ambohidratrimo',
                        'adress'=>'Ambovo',
                        'birth_id'=>$birth->id
                    ]
                )->save();
                $patients[]=['firstName'=>$patient->firstName,'id'=>$patient->id];
                //if there is birth injury
                if(count($request->injuries)>0){
                    foreach ($request->injuries as $injury){
                        BirthMomInjury::create([
                            "where"=>$injury["where"],
                            "position"=>$injury["position"],
                            "degree"=>$injury["degree"],
                            "birth_id"=>$birth->id,
                        ]);
                    }
                }
                BirthMedicalDataBaby::create_birth_medical_data($data,$birth->id,$patient->id);
//                //insert the infos about the baby to the admin table
                BirthAdminData::create(
                    [
                        'baby_firstName'=>$data['firstName'],
                        'baby_lastName'=>$data['lastName'],
                        'baby_gender'=>$data['gender'],
                        'birth_id'=>$birth->id
                    ]
                );
//                //register the infos about the mom
                BirthMedicalDataMom::create_medical_data($request,$birth->id);
//                //register the used medicines and launch inventories operations
                if(count($request->medicines_used_during)>0){
                    foreach($request->medicines_used_during as $med){
//                        BirthUsedMedicine::create([
//                            'birth_id'=>$birth->id,
//                            'item_id'=>$med['item'],
//                            'quantity'=>$med['quantity']
//                        ]);
                        BirthUsedMedicineDuring::create([
                            'birth_id'=>$birth->id,
                            'medicine'=>$med['item'],
                            'quantity'=>$med['quantity'],
                            'time'=>$med['time']
                        ]);
                    }
                }
                if(count($request->medicines_used_after)>0){
                    foreach($request->medicines_used_after as $med){
                        BirthUsedMedicineAfter::create([
                            'birth_id'=>$birth->id,
                            'medicine'=>$med['item'],
                            'quantity'=>$med['quantity'],
                            'time'=>$med['time']
                        ]);
                    }
                }
                $digit++;
            }

            return response()->json([
                'success'=>true,
                'msg'=>'Birth Data successfully saved',
                'patients'=>$patients
            ]);
    }

    public static function deliveryBook(){
        return Birth::with(['BirthAdminData','patient','birthMedicalDataBabies','birthMedicalDataMoms','cpnAdmission','birth_mom_injuries'])->get()
            ->map(function($birth){
                return [
                    "ref"=>$birth->code,
                    "mom"=>[
                        "patient_id"=>$birth->patient['id'],
                        "fullName"=>$birth->patient['firstName']." ".$birth->patient['lastName'],
                        'birthDate'=>$birth->patient['birthDate'],
                        'address'=>$birth->patient['adress'],
                        'G'=>$birth->cpnAdmission['gravida'],'P'=>$birth->cpnAdmission['parity'],'A'=>$birth->cpnAdmission['abortion'],'EV'=>$birth->cpnAdmission['ev'],'M'=>$birth->cpnAdmission['miscarriage'],
                        'lpd'=>$birth->cpnAdmission['dda'],
                        'placenta_time'=>$birth->birthMedicalDataMoms[0]['placenta_time'],
                        'placenta_complete'=>$birth->birthMedicalDataMoms[0]['placenta_complete'],
                        'placenta_manual_revision'=>$birth->birthMedicalDataMoms[0]['placenta_manual_delivery'],
                        'placenta_curetage'=>$birth->birthMedicalDataMoms[0]['placenta_curetage'],
                        'anesthesia'=>$birth->birthMedicalDataMoms[0]['anesthesia'],
                        'position'=>$birth->birthMedicalDataMoms[0]['position'],
                    ],
                    "delivery"=>[
                        'date'=>$birth->birth_date,
                        'time'=>$birth->birth_time,
                        'GA'=>$birth->GA,
                        'complication_mom_before_birth'=>$birth->birthMedicalDataMoms[0]['complication_mom_before_birth'],
                        'complication_mom_after_birth'=>$birth->birthMedicalDataMoms[0]['complication_mom_after_birth'],
                        'injuries'=>json_encode($birth->birth_mom_injuries->map(function($injury){
                            return "(".$injury->where."-".$injury->position."-".$injury->degree.")";
                        })),
                        'stiches'=>$birth->birthMedicalDataMoms[0]['stiches'],
                        'blood_loss'=>$birth->birthMedicalDataMoms[0]['blood_loss'],
                        'induction'=>$birth->induction,
                        'induction_method'=>$birth->induction_method,
                        'sterilisation_package'=>$birth->birthMedicalDataMoms[0]['sterilisation_package'],
                    ],
                    "medicines"=>[],
                    "baby"=>[
                        'id'=>$birth->birthMedicalDataBabies[0]['patient_id'],
                        'firstName'=>$birth->birthAdminData[0]['baby_firstName'],
                        'lastName'=>$birth->birthAdminData[0]['baby_lastName'],
                        'gender'=>$birth->birthAdminData[0]['baby_gender'],
                        'modus'=>$birth->birthMedicalDataBabies[0]['modus'],
                        'position'=>$birth->birthMedicalDataBabies[0]['position'],
                        'malformation'=>$birth->birthMedicalDataBabies[0]['malformation'],
                        'weight'=>$birth->birthMedicalDataBabies[0]['weight'],
                        'length'=>$birth->birthMedicalDataBabies[0]['length'],
                        'head'=>$birth->birthMedicalDataBabies[0]['head'],
                        'chest'=>$birth->birthMedicalDataBabies[0]['chest'],
                        'arm'=>$birth->birthMedicalDataBabies[0]['arm'],
                        'apgar'=>$birth->birthMedicalDataBabies[0]['apgar_1']."/".$birth->birthMedicalDataBabies[0]['apgar_2']."/".$birth->birthMedicalDataBabies[0]['apgar_3'],
                        'vit_k'=>$birth->birthMedicalDataBabies[0]['vit_k'],
                        'E1'=>$birth->birthMedicalDataBabies[0]['E1'],
                        'correlation'=>$birth->birthMedicalDataBabies[0]['correlation'],

                    ],
                    'timeline'=>[
                        "time_arrived"=>'',
                        "time_dismissed"=>''
                    ],
                   'responsibles'=>[]
                ];
            });


    }
}
