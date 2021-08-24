<?php

use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\centralized\patientController;
use App\Models\BloodGroup;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// return countries list
Route::get('/countries',[App\Http\Controllers\centralized\CountryController::class, 'index']);
// return  type_consultations
Route::resource('/typeConsult',\App\Http\Controllers\joyCenter\TypeConsultController::class);
//service Price controller
Route::resource('/servicePrice',\App\Http\Controllers\joyCenter\servicePriceController::class);
// return fokontany list
Route::get('/fokontany',[App\Http\Controllers\centralized\fktController::class, 'index']);
//Return bloodgroup list
Route::get('/blood_group',function(){
    return BloodGroup::All();
});
//Return birth problem list
Route::get('/pregnancy_problem',function(){
    return \App\Models\PregnancyProblems::all();
});
// Cervix position
Route::get('/cervix_position',function(){
    return \App\Models\CervixPosition::all();
});
//Cervix length
Route::get('/cervix_length',function(){
    return \App\Models\CervixLength::all();
});
//Cervix opening
Route::get('/cervix_opening',function(){
    return \App\Models\CervixOpening::all();
});
// position of babies
Route::get('/position_of_baby',function(){
    return \App\Models\PositionOfBaby::all();
});
// presentation of babies
Route::get('/presentation_of_baby',function(){
    return \App\Models\PresentationOfBaby::all();
});
// type of birth
Route::get('/birth_type',function(){
    return \App\Models\BirthType::all();
});
// lp1
Route::get('/lp1',function(){
        return \App\Models\lpi::get();
});
//lp2
Route::get('/lp2',function(){
    return \App\Models\lpii::all();
});
// lp3
Route::get('/lp3',function(){
    return \App\Models\lpiii::all();
});
// placenta_type
Route::get('/placenta_type',function(){
    return \App\Models\PlacentaType::all();
});
//patient category
Route::get('/patient_category',function(){
    return \App\Models\PatientCategory::all();
});
//mhm partners
Route::get('/mhm_partner',function(){
    return \App\Models\MhmPartner::all();
});
// diag_code
Route::get('/diag_code',function(){
    return \App\Models\DiagCode::all();
});
//hospital service list
Route::get('/hospital_service',function(){
    return cache()->rememberForever('hospital_service',function(){
        return \App\Models\HospitalService::all();
    });
});
//hospital service division list
Route::get('/hospital_service_division',function(){
    return cache()->rememberForever('hospital_service_division',function(){
       return \App\Models\HospitalServiceDivision::all();
    });
});
//bed list
Route::get('/bed_list',function(){
    return cache()->rememberForever('bed_list',function(){
        return \App\Models\Bed::all();
    });
});
Route::get('/free_bed/{division_id}',[\App\Http\Controllers\medical\beds\BedController::class,'free_in_division']);
// maternity actions list
Route::get('/maternity_action_list',function(){
    return \App\Models\MaternityActionList::all();
});


//verify credentials
Route::post('/auth/credentials/',[App\Http\Controllers\Auth\CredentialController::class,'check']);
Route::get('/paginate',function(){
    return Patient::paginate(20);
});

//Consultation resource controller
//Route::post('/consultation/today',[\App\Http\Controllers\joyCenter\ConsultationController::class,'check_today_consultation']);
//Route::resource('/consultation', \App\Http\Controllers\joyCenter\ConsultationController::class);
    //consultation beta
        // get today consultation base on the type of consultation
        Route::get('/consultation/today/{type}',[\App\Http\Controllers\V1\consultation\ConsultationController::class,'today_consultation_by_type']);
        Route::post('/consultation/check_patient_today',[\App\Http\Controllers\V1\consultation\ConsultationController::class,'check_patient_today_consultation']);
        Route::resource('/consultation', \App\Http\Controllers\V1\consultation\ConsultationController::class);
//patient routes
Route::get('/patients/search/',[App\Http\Controllers\centralized\patientController::class, 'search']);
Route::get('/patients/vitalSign/{id}',[App\Http\Controllers\centralized\patientController::class, 'vitalSign']);
Route::post('/patients/filter',[App\Http\Controllers\centralized\patientController::class, 'filter']);
Route::resource('/patients',patientController::class);
//cash routes
Route::group(['prefix'=>'cash'],function(){
    route::get('/details/{consult_id}',[App\Http\Controllers\cash\cashController::class, 'details_per_consult']);
    route::post('/finalize',[App\Http\Controllers\cash\cashController::class, 'finalize_transaction']);
    route::get('/finance_rezept',[App\Http\Controllers\cash\cashController::class,'finance_rezept']);
});
//Maternity routes
Route::group(['prefix'=>'maternity'],function(){
    route::get('/fetch_patient_data/{patient_id}',[\App\Http\Controllers\medical\maternity\MaternityAdmissionController::class,'fetch_patient_data']);
    route::get('/last_code',[\App\Http\Controllers\medical\maternity\MaternityAdmissionController::class,'last_code']);
    route::get('/last_birth_code',[\App\Http\Controllers\medical\maternity\BirthRegistrationController::class,'last_birth_code']);
    route::post('/upload_files',[\App\Http\Controllers\medical\maternity\MaternityAdmissionController::class,'upload_files']);
    route::put('/delivery_registration/birth_certificate/{id}',[\App\Http\Controllers\medical\maternity\BirthRegistrationController::class,'birth_certificate']);
    route::resource('/delivery_registration',\App\Http\Controllers\medical\maternity\BirthRegistrationController::class);
    route::resource('/maternity_admission',\App\Http\Controllers\medical\maternity\MaternityAdmissionController::class);
    route::resource('/actions',\App\Http\Controllers\medical\maternity\MaternityActionController::class);
    route::resource('/medical_appreciation',\App\Http\Controllers\medical\maternity\MedicalAppreciationController::class);
    route::resource('/medical_appreciation_comment',\App\Http\Controllers\medical\maternity\MedicalAppreciationCommentController::class);

});

//obstetrics routes
Route::group(['prefix'=>'obstetrics'],function(){
    route::post('/cpn_admission',[App\Http\Controllers\medical\obstetrics\ObstetricsController::class,'store']);
    route::put('/cpn_admission/{reference}',[App\Http\Controllers\medical\obstetrics\ObstetricsController::class,'update']);
    route::get('/cpn/{reference}',[App\Http\Controllers\medical\obstetrics\ObstetricsController::class,'show']);
    route::post('/pregTest',[App\Http\Controllers\medical\obstetrics\ObstetricsController::class,'storePregTest']);
    route::get('/first_cpn_list',function(){return Consultation::where('type_consult_id',4)->whereDate('created_at', '=', date('Y-m-d'))->with(['patient','vitalSigns'])->get();});
    route::get('/search',[App\Http\Controllers\medical\obstetrics\ObstetricsController::class,'search']);
    route::resource('/cpn_followup',\App\Http\Controllers\medical\obstetrics\CpnFollowupController::class);
    route::resource('ultrasound',\App\Http\Controllers\medical\obstetrics\UltraSoundController::class);
        // baby checkup routes
    route::get('/baby_checkup/todayList',[App\Http\Controllers\medical\obstetrics\BabyCheckupController::class,'todayList']);
    route::get('/baby_vaccination/todayList',[App\Http\Controllers\medical\obstetrics\BabyVaccinationController::class,'todayList']);
    route::resource('/baby_checkup',\App\Http\Controllers\medical\obstetrics\BabyCheckupController::class);
    route::resource('/baby_vaccination',\App\Http\Controllers\medical\obstetrics\BabyVaccinationController::class);
});
//generalist
Route::group(['prefix'=>'generalist'],function(){
    route::resource('/consultation',\App\Http\Controllers\V1\medical\generalist\GeneralistController::class);
});
