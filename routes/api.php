<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\centralized\patientController;

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
    route::get('/service_list',[\App\Http\Controllers\hospitalisation\hospitalAdmissionController::class,'service_list']);
    route::get('/division_list/{service_id}',[\App\Http\Controllers\hospitalisation\hospitalAdmissionController::class,'division_list']);
    route::get('/bed_list/{division_id}',[\App\Http\Controllers\hospitalisation\hospitalAdmissionController::class,'bed_list']);
});
//obstetrics routes
Route::group(['prefix'=>'obstetrics'],function(){
    route::get('/baby/weight_overview/{id}',[App\Http\Controllers\medical\obstetrics\BabyController::class,'fetch_data']);
    route::post('/cpn/admission',[\App\Http\Controllers\medical\obstetrics\ObstetricAdmissionController::class,'store']);
});
