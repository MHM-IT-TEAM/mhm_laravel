<?php


use App\Models\BloodGroup;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

Route::prefix('/v1')->group(function(){
    //patient system
    Route::group(['prefix'=>'patient_system'],function(){
        //patient
        Route::group(['prefix'=>'patient'],function(){
            Route::get('/category',function(){
                return \App\Models\PatientCategory::all();
            });
            //patient quick search
            Route::get('/search',[\App\Http\Controllers\v1\patient_system\patient\PatientController::class,'search']);
            Route::get('/with_due_sum/{id}',[\App\Http\Controllers\v1\patient_system\patient\PatientController::class,'with_due_sum']);
            Route::resource('patient',\App\Http\Controllers\v1\patient_system\patient\PatientController::class);
        });
        //Admission
        Route::group(['prefix'=>'admission'],function(){
            Route::resource('priority',\App\Http\Controllers\V1\patient_system\consultation\AdmissionPriorityController::class);
            Route::get('list_today',[\App\Http\Controllers\V1\patient_system\admission\AdmissionController::class,'list_today']);
            Route::post('check_patient_today',[\App\Http\Controllers\V1\patient_system\consultation\ConsultationController::class,'check_patient_today_consultation']);
            Route::get('activity_price/{service_activity}/{patient_category}',[\App\Http\Controllers\v1\patient_system\consultation\ServicePriceController::class,'filter_per_service']);
            Route::resource('service_price',\App\Http\Controllers\v1\patient_system\consultation\ServicePriceController::class);
            Route::resource('admission',\App\Http\Controllers\V1\patient_system\admission\AdmissionController::class);
        });
        //out patient
        Route::group(['prefix'=>'out_patient'],function(){

        });
        //System
        Route::group(['prefix'=>'system'],function(){
            Route::get('seniors',function(){return \App\Models\Senior::all();});
            Route::resource('category',\App\Http\Controllers\V1\System\CategoryController::class);
            Route::get('service/category/{category}',[\App\Http\Controllers\V1\System\ServiceController::class,'where_category']);
            Route::get('serviceActivity/service/{service_id}',[\App\Http\Controllers\V1\System\ServiceActivityController::class,'whereService']);
            Route::resource('serviceActivity',\App\Http\Controllers\V1\System\ServiceActivityController::class);
            Route::resource('service',\App\Http\Controllers\V1\System\ServiceController::class);
        });
    });
    Route::group(['prefix'=>'extra'],function(){
//list of sector fokontany
        Route::get('fokontany',function(){
            return \App\Models\Fokontany::all();
        });
//list of mhm partners
        Route::get('mhm_partner',function(){
            return \App\Models\MhmPartner::all();
        });
// list of countries
        Route::get('countries',function(){
            return  Storage::get("public/countries.txt");
        });
//Return bloodgroup list
        Route::get('/blood_group',function(){
            return BloodGroup::All();
        });
//Return birth problem list
        Route::get('pregnancy_problem',function(){
            return \App\Models\PregnancyProblems::all();
        });
// Cervix position
        Route::get('cervix_position',function(){
            return \App\Models\CervixPosition::all();
        });
//Cervix length
        Route::get('cervix_length',function(){
            return \App\Models\CervixLength::all();
        });
//Cervix opening
        Route::get('cervix_opening',function(){
            return \App\Models\CervixOpening::all();
        });
// position of babies
        Route::get('position_of_baby',function(){
            return \App\Models\PositionOfBaby::all();
        });
// presentation of babies
        Route::get('presentation_of_baby',function(){
            return \App\Models\PresentationOfBaby::all();
        });
// type of birth
        Route::get('birth_type',function(){
            return \App\Models\BirthType::all();
        });
// lp1
        Route::get('lp1',function(){
            return \App\Models\lpi::get();
        });
//lp2
        Route::get('lp2',function(){
            return \App\Models\lpii::all();
        });
// lp3
        Route::get('lp3',function(){
            return \App\Models\lpiii::all();
        });
// placenta_type
        Route::get('placenta_type',function(){
            return \App\Models\PlacentaType::all();
        });
    });
});
