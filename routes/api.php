<?php


use App\Models\BloodGroup;
use Illuminate\Http\Request;
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
            Route::get('list_today_service/{service_id}',[\App\Http\Controllers\V1\patient_system\admission\AdmissionController::class,'list_today_service']);
//            Route::post('check_patient_today',[\App\Http\Controllers\V1\patient_system\consultation\ConsultationController::class,'check_patient_today_consultation']);
            Route::get('activity_price/{service_activity}/{patient_category}',[\App\Http\Controllers\v1\patient_system\consultation\ServicePriceController::class,'filter_per_service']);
            Route::resource('service_price',\App\Http\Controllers\v1\patient_system\consultation\ServicePriceController::class);
            Route::resource('admission',\App\Http\Controllers\V1\patient_system\admission\AdmissionController::class);
        });
        //Internal referral
        Route::resource('internal_referral',\App\Http\Controllers\V1\patient_system\internal_referral\InternalReferralController::class);
        //Internal Lab
        Route::group(['prefix'=>'internal_lab'],function(){
            Route::post('open_request',[\App\Http\Controllers\V1\patient_system\internal_lab\InternalLabController::class,'open_request']);
            Route::post('save_result',[\App\Http\Controllers\V1\patient_system\internal_lab\InternalLabController::class,'save_result']);
            Route::resource('resource',\App\Http\Controllers\V1\patient_system\internal_lab\InternalLabController::class);
        });

        //Cashier
        Route::group(['prefix'=>'cashier'],function(){
            Route::get('patient_due/{patient_id}',[\App\Http\Controllers\V1\patient_system\cashier\PaymentController::class,'patient_due']);
            Route::get('former_transactions_list/{patient_id}',[\App\Http\Controllers\V1\patient_system\cashier\PaymentController::class,'former_transaction_list']);
            Route::get('unpaid_today',[\App\Http\Controllers\V1\patient_system\cashier\PaymentController::class,'unpaid_today']);
            Route::post('pay',[\App\Http\Controllers\V1\patient_system\cashier\PaymentController::class,'pay']);
            Route::post('pay_previous_transaction',[\App\Http\Controllers\V1\patient_system\cashier\PaymentController::class,'pay_previous_transaction']);
        });
        //out patient
        Route::group(['prefix'=>'out_patient'],function(){
            Route::group(['prefix'=>'generalist'],function(){
                Route::get('diag_codes',function(){
                   return \App\Models\DiagCode::all();
                });
                Route::resource('consultation',App\Http\Controllers\V1\patient_system\out_patient\general\GeneralistController::class);

            });
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
    Route::group(['prefix'=>'inventory_system'],function(){
        Route::get('/app/bootstrap',[\App\Http\Controllers\V1\inventory_system\app\BootstrapController::class,'bootstrap']);

        //Location
        Route::get('/location',function(){
            return \App\Models\inventory_system\Location::all();
        });
        //Departments
        Route::get('/department',function(){
            return \App\Models\Department::all();
        });
        //Collector
        Route::get('collector/{department_id}',[\App\Http\Controllers\V1\inventory_system\collector\CollectorController::class,'fetch_by_department']);
        Route::resource('collector',\App\Http\Controllers\V1\inventory_system\collector\CollectorController::class);
        //item types
        Route::get('/item_type',function(){
            return \App\Models\inventory_system\ItemType::all();
        });
        //item units
        Route::get('/item_unit',function(){
            return \App\Models\inventory_system\ItemUnit::all();
        });
        //item administration
        Route::get('/item_administration',function(){
            return \App\Models\inventory_system\ItemAdministration::all();
        });
        //out
        Route::get('/out/lastCode',[\App\Http\Controllers\V1\inventory_system\out\OutController::class,'lastCode']);
        Route::get('out/pending',[\App\Http\Controllers\V1\inventory_system\out\OutController::class,'pending_list']);
        Route::get('out/delivered',[\App\Http\Controllers\V1\inventory_system\out\OutController::class,'delivered_list']);
        Route::resource('out',\App\Http\Controllers\V1\inventory_system\out\OutController::class);
        Route::middleware('auth:api')->get('/user', function (Request $request) {
            return $request->user();
        });
        //low_stock
        Route::get('low_stock',[\App\Http\Controllers\V1\inventory_system\low_stock\LowStockController::class,'list']);
        //Route::get('/item/count_low_stock',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'count_low_stock']);
        //item
        Route::post('/item/inventory/update',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'update_inventory']);
        Route::get('/item/count_per_type',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'count_per_type']);
        Route::get('item/code',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'getCode']);
        Route::resource('item',\App\Http\Controllers\V1\inventory_system\item\ItemController::class);
        //Cart
        Route::get('/cart/lastCode',[\App\Http\Controllers\V1\inventory_system\cart\CartController::class,'lastCode']);
        Route::resource('/cart',\App\Http\Controllers\V1\inventory_system\cart\CartController::class);
        //IN
        Route::patch('/in/validate/{id}',[\App\Http\Controllers\V1\inventory_system\in\InController::class,'validate_stock']);
        Route::get('/in/lastCode',[\App\Http\Controllers\V1\inventory_system\in\InController::class,'lastCode']);
        Route::resource('in',\App\Http\Controllers\V1\inventory_system\in\InController::class);
        //excels
        Route::get('/excel/items',[\App\Http\Controllers\V1\inventory_system\excel\ExcelController::class,'items']);
        //pdf
        //Route::get('/pdf/shopping_list/{id}',[\App\Http\Controllers\V1\inventory_system\pdf\PdfController::class,'shopping_list']);
        //Grace Center
        Route::group(['prefix'=>'grace_center'],function(){
            Route::resource('/csb_transaction',\App\Http\Controllers\V1\inventory_system\grace_center\GraceCsbTransactionController::class);
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
