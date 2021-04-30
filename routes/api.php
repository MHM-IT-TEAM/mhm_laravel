<?php

use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/connected_user',[App\Http\Controllers\TestController::class,'index']);
// return countries list
Route::get('/countries',[App\Http\Controllers\centralized\CountryController::class, 'index']);
// return  type_consultations
Route::resource('/typeConsult',\App\Http\Controllers\joyCenter\TypeConsultController::class);
//service Price controller
Route::resource('/servicePrice',\App\Http\Controllers\joyCenter\servicePriceController::class);
//Consultation resource controller
Route::resource('/consultation', \App\Http\Controllers\joyCenter\ConsultationController::class);
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
// lp1
Route::get('/lp1',function(){
    return \App\Models\lpi::all();
});
//lp2
Route::get('/lp2',function(){
    return \App\Models\lpii::all();
});
// lp3
Route::get('/lp3',function(){
    return \App\Models\lpiii::all();
});
//patient routes
Route::get('/patients/search/',[App\Http\Controllers\centralized\patientController::class, 'search']);
Route::get('/patients/vitalSign/{id}',[App\Http\Controllers\centralized\patientController::class, 'vitalSign']);
Route::resource('/patients',patientController::class);
//cash routes
Route::group(['prefix'=>'cash'],function(){
    route::get('/details/{consult_id}',[App\Http\Controllers\cash\cashController::class, 'details_per_consult']);
    route::post('/finalize',[App\Http\Controllers\cash\cashController::class, 'finalize_transaction']);
    route::get('/finance_rezept',[App\Http\Controllers\cash\cashController::class,'finance_rezept']);
});
//hospitalisation routes
Route::group(['prefix'=>'hospitalisation'],function(){
    //route::get('/service_list',[\App\Http\Controllers\hospitalisation\hospitalAdmissionController::class,'service_list']);
    //route::get('/division_list/{service_id}',[\App\Http\Controllers\hospitalisation\hospitalAdmissionController::class,'division_list']);
    //route::get('/bed_list/{division_id}',[\App\Http\Controllers\hospitalisation\hospitalAdmissionController::class,'bed_list']);
});
//obstetrics routes
Route::group(['prefix'=>'obstetrics'],function(){
    route::post('/cpn_admission',[App\Http\Controllers\medical\obstetrics\ObstetricsController::class,'store']);
    route::put('/cpn_admission/{reference}',[App\Http\Controllers\medical\obstetrics\ObstetricsController::class,'update']);
    route::get('/baby/weight_overview/{id}',[App\Http\Controllers\medical\obstetrics\BabyController::class,'fetch_data']);
    route::get('/cpn/{reference}',[App\Http\Controllers\medical\obstetrics\ObstetricsController::class,'show']);
    route::post('/pregTest',[App\Http\Controllers\medical\obstetrics\ObstetricsController::class,'storePregTest']);
    route::get('/first_cpn_list',function(){return Consultation::where('type_consult_id',4)->whereDate('created_at', '=', date('Y-m-d'))->with(['patient','vitalSigns'])->get();});
    route::get('/search',[App\Http\Controllers\medical\obstetrics\ObstetricsController::class,'search']);
    route::resource('/cpn_followup',\App\Http\Controllers\medical\obstetrics\CpnFollowupController::class);
    route::resource('ultrasound',\App\Http\Controllers\medical\obstetrics\UltraSoundController::class);

});
