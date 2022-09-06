<?php


use App\Models\BloodGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

Route::prefix('/v1')->group(function(){
    //Admin
    Route::group(['prefix'=>'admin'],function(){
        //users
            Route::resource('users',\App\Http\Controllers\V1\admin\UserController::class);
            Route::post('update_user_page',[\App\Http\Controllers\V1\admin\UserController::class,'update_user_page']);
        //Pages
            Route::resource('pages',\App\Http\Controllers\V1\admin\PageController::class);
        //statistics
            Route::get('statistics_overview',[\App\Http\Controllers\V1\admin\AdminController::class,'statistics_overview']);


    });
    //patient system
    Route::group(['prefix'=>'patient_system'],function(){
        //patient
        Route::group(['prefix'=>'patient'],function(){
            Route::get('/category',function(){
                return \App\Models\PatientCategory::all();
            });
            Route::get('update_category/{patient_id}/{category_id}',[\App\Http\Controllers\v1\patient_system\patient\PatientController::class,'update_category']);
            //patient quick search
            Route::get('/search',[\App\Http\Controllers\v1\patient_system\patient\PatientController::class,'search']);
            Route::get('/with_due_sum/{id}',[\App\Http\Controllers\v1\patient_system\patient\PatientController::class,'with_due_sum']);
            Route::resource('patient',\App\Http\Controllers\v1\patient_system\patient\PatientController::class);
        });
        //Vital sign
        Route::resource('vital_sign',\App\Http\Controllers\V1\patient_system\vital_sign\VitalSignController::class);
        //Admission
        Route::group(['prefix'=>'admission'],function(){
            Route::resource('priority',\App\Http\Controllers\V1\patient_system\consultation\AdmissionPriorityController::class);
            Route::get('list_today',[\App\Http\Controllers\V1\patient_system\admission\AdmissionController::class,'list_today']);
            Route::post('list_service_activity_date',[\App\Http\Controllers\V1\patient_system\admission\AdmissionController::class,'list_service_activity_date']);
//            Route::post('check_patient_today',[\App\Http\Controllers\V1\patient_system\consultation\ConsultationController::class,'check_patient_today_consultation']);
            Route::get('activity_price/{service_activity}/{patient_category}',[\App\Http\Controllers\v1\patient_system\consultation\ServicePriceController::class,'filter_per_service']);
            Route::resource('service_price',\App\Http\Controllers\v1\patient_system\consultation\ServicePriceController::class);
            Route::resource('admission',\App\Http\Controllers\V1\patient_system\admission\AdmissionController::class);
        });
        //Internal referral
        Route::resource('internal_referral',\App\Http\Controllers\V1\patient_system\internal_referral\InternalReferralController::class);
        //External referral
        Route::resource('external_referral',\App\Http\Controllers\V1\patient_system\external_referral\ExternalReferralController::class);
        //Internal consultation
            //internalConsultationType
            Route::get('internal_consultation_types',[\App\Http\Controllers\v1\patient_system\internal_consultation\InternalConsultationController::class,'get_all_types']);
            Route::resource('internal_consultation',\App\Http\Controllers\v1\patient_system\internal_consultation\InternalConsultationController::class);
        //External consultation
            Route::resource('external_consultation',\App\Http\Controllers\V1\patient_system\external_consultation\ExternalConsultationController::class);
        //Internal Lab
        Route::group(['prefix'=>'internal_lab'],function(){
            Route::post('open_request',[\App\Http\Controllers\V1\patient_system\labwork\InternalLabController::class,'open_request']);
            Route::post('save_result',[\App\Http\Controllers\V1\patient_system\labwork\InternalLabController::class,'save_result']);
            Route::resource('resource',\App\Http\Controllers\V1\patient_system\labwork\InternalLabController::class);
        });
        //Grace center
        Route::group(['prefix'=>'grace_center'],function(){
            Route::get('patient_list',[\App\Http\Controllers\V1\patient_system\grace_center\GraceCenterController::class,'index']);
            Route::post('store',[\App\Http\Controllers\V1\patient_system\grace_center\GraceCenterController::class,'store']);
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
            //general doctor
            Route::group(['prefix'=>'generalist'],function(){
                Route::get('diag_codes',function(){
                   return \App\Models\DiagCode::all();
                });
                Route::resource('consultation',App\Http\Controllers\V1\patient_system\out_patient\general\GeneralistController::class);

            });
            //Dentist
            Route::group(['prefix'=>'dentist'],function(){
                Route::get('today_task/{patient_id}',[\App\Http\Controllers\V1\patient_system\out_patient\dental\DentalTreatmentController::class,'today_task']);
                Route::get('check_if_followup/{patient_id}',[\App\Http\Controllers\V1\patient_system\out_patient\dental\DentalTreatmentController::class,'check_if_followup']);
                Route::get('patient_last_checkup/{patient_id}', [\App\Http\Controllers\V1\patient_system\out_patient\dental\DentalChekupController::class,'patient_last_checkup']);
                Route::post('send_to_cashier', [\App\Http\Controllers\V1\patient_system\out_patient\dental\DentalChekupController::class,'send_to_cashier']);
                Route::resource('dental_checkup',\App\Http\Controllers\V1\patient_system\out_patient\dental\DentalChekupController::class);
                Route::resource('dental_treatment',\App\Http\Controllers\V1\patient_system\out_patient\dental\DentalTreatmentController::class);
            });
            //Obstetrics
            Route::group(['prefix'=>'obstetrical'],function() {
                //New CPN routes
                Route::group(['prefix'=>'cpn'],function(){
                    Route::resource('admission',App\Http\Controllers\V1\patient_system\out_patient\obstetrical\CpnAdmissionController::class);
                    Route::get('get_ultrasound_admission_data/{patient_id}',[App\Http\Controllers\V1\patient_system\out_patient\obstetrical\CpnAdmissionController::class,'get_ultrasound_admission_data']);
                    Route::resource('followup',\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\CpnFollowupController::class);
                    Route::post('patient_cpn_search',[\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\CpnAdmissionController::class,'patient_cpn_search']);
                    Route::get('patient_list_of_cpn_admissions/{patient_id}',[\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\CpnAdmissionController::class,'patient_list_of_cpn_admissions']);
                    Route::get('get_recent_cpn_admissions_for_patient/{patient_id}', [\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\CpnFollowupController::class, 'get_recent_cpn_admissions_for_patient']);
                });
                //new ultrasound routes
                Route::group(['prefix'=>'ultrasound'],function(){
                    Route::post('admission',[\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\UltrasoundController::class,'admission']);
                    Route::get('admission_list/{patient_id}',[\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\UltrasoundController::class,'admission_list']);
                    Route::post("details",[\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\UltrasoundController::class,'details']);
                    Route::get("details/{ultrasound_admission_id}",[\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\UltrasoundController::class,'get_details']);
                    Route::post("patient_search",[\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\UltrasoundController::class,'patient_search']);
                    Route::put("close_exam/{ultrasound_admission_id}",[\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\UltrasoundController::class,'close_exam']);
                    Route::get("patient/{patient_id}",[\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\UltrasoundController::class,'where_patient_id']);
                });
                // Baby Checkup
                    Route::group(['prefix'=>'baby'],function(){
                        Route::resource('checkup',\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\BabyCheckupController::class);
                        Route::resource('vaccination',\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\BabyVaccinationController::class);
                        //sickness
                        Route::resource('sickness',\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\BabySicknessController::class);
                    });

                //Milk program
                    Route::group(['prefix'=>'milkPro'],function(){
                        Route::resource('main',\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\BabyMilkProgramController::class);
                        Route::get('patient/{patient_id}',[\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\BabyMilkProgramController::class,'show_patient_milk_pro_admission']);
                        Route::post('store_followup',[\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\BabyMilkProgramController::class,'store_followup']);
                    });
                //Family planning
                Route::group(['prefix'=>'family_planning'],function(){
                    Route::resource('main',\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\FamilyPlanningController::class);
                });
                //POSTPARTUM
                Route::resource('postpartum',\App\Http\Controllers\V1\patient_system\out_patient\obstetrical\PostPartController::class);

            });
        });
        // In patient
        Route::group(['prefix'=>'in_patient'],function(){
            Route::get('service/{category_id}',function($id){
                return \App\Models\Service::where('category_id',$id)->get();
            });
            Route::get('bed/{service_id}',function($id){
                return \App\Models\Bed::where('service_id',$id)->where('occupied',false)->get();
            });

            //Stork center
            Route::group(['prefix'=>'stork'],function(){
                route::resource('admission',\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkAdmissionController::class);
                route::resource('balance',\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkBalanceController::class);
                route::get('balance/stork_admission_id/{stork_admission_id}',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkBalanceController::class,'stork_balance_where_admission_id']);
                route::post('store_balance_in',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkBalanceController::class,'store_in']);
                route::post('store_balance_out',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkBalanceController::class,'store_out']);
                route::post('close_balance',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkBalanceController::class,'close_balance']);
                route::post('give_medicine',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkMedicineController::class,'give_medicine']);
                route::post('store_diagnose',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkDiagnoseController::class,'store']);
                route::get('show_diagnose/{stork_admission_id}',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkDiagnoseController::class,'show']);
                route::post('store_wound_care',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkWoundCareController::class,'store']);
                route::get('show_wound_care/{stork_admission_id}',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkWoundCareController::class,'show']);
                route::post('store_action',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkActionController::class,'store']);
                route::get('show_action/{stork_admission_type}/{action_type}',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkActionController::class,'show']);
                route::post('ext_ref_update_stork_admission',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkExternalReferralController::class,'update_stork_admission']);
                route::get('show_medicine/{stork_admission_id}',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkMedicineController::class,'show']);
                route::resource('pregnancy_checkup',\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkPregnancyCheckupController::class);
                route::get('pregnancy_checkup/stork_admission_id/{stork_admission_id}',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkPregnancyCheckupController::class,'where_stork_admission_id']);
                route::resource('dismissal',\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkDismissalController::class);
                route::get('in_patient_book',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkAdmissionController::class,'in_patient_book']);
                route::get('weekly_measurments/show_list/{stork_admission_id}',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkWeeklyMeasurmentController::class,'show_list']);
                route::resource('weekly_measurments',\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkWeeklyMeasurmentController::class);
                route::post('change_bed',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkAdmissionController::class,'change_bed']);
                route::post('update_admission_by_ir',[\App\Http\Controllers\V1\patient_system\in_patient\stork_center\StorkAdmissionController::class,'update_admission_by_ir']);
//                route::get('/fetch_patient_data/{patient_id}',[\App\Http\Controllers\V1\patient_system\maternity\MaternityAdmissionController::class,'fetch_patient_data']);
//                route::get('/last_code',[\App\Http\Controllers\V1\patient_system\maternity\MaternityAdmissionController::class,'last_code']);
//                route::get('/last_birth_code',[\App\Http\Controllers\V1\patient_system\maternity\BirthRegistrationController::class,'last_birth_code']);
//                route::post('/upload_files',[\App\Http\Controllers\V1\patient_system\maternity\MaternityAdmissionController::class,'upload_files']);
//                route::put('/delivery_registration/birth_certificate/{id}',[\App\Http\Controllers\V1\patient_system\maternity\BirthRegistrationController::class,'birth_certificate']);
//                route::resource('/delivery_registration',\App\Http\Controllers\V1\patient_system\maternity\BirthRegistrationController::class);
//                route::resource('/maternity_admission',\App\Http\Controllers\V1\patient_system\maternity\MaternityAdmissionController::class);
//                route::resource('/actions',\App\Http\Controllers\V1\patient_system\maternity\MaternityActionController::class);
//                route::resource('/medical_appreciation',\App\Http\Controllers\V1\patient_system\maternity\MedicalAppreciationController::class);
//                route::resource('/medical_appreciation_comment',\App\Http\Controllers\V1\patient_system\maternity\MedicalAppreciationCommentController::class);

            });
        });
        // Delivery
        Route::group(['prefix'=>'delivery'],function(){
            route::get('last_code',[\App\Http\Controllers\V1\patient_system\delivery\BirthRegistrationController::class,'last_birth_code']);
            route::get('patient_data/{patient_id}',[\App\Http\Controllers\V1\patient_system\delivery\BirthRegistrationController::class,'fetch_patient_data']);
            route::post('register_birth',[\App\Http\Controllers\V1\patient_system\delivery\BirthRegistrationController::class,'register_birth']);
            route::get('birth_certificate/{code}',[\App\Http\Controllers\V1\patient_system\delivery\BirthRegistrationController::class,'show']);
            route::put('birth_certificate/{code}',[\App\Http\Controllers\V1\patient_system\delivery\BirthRegistrationController::class,'birth_certificate']);
            route::get('book',[\App\Http\Controllers\V1\patient_system\delivery\BirthRegistrationController::class,'book']);
        });
        // Surgery
        Route::group(['prefix'=>'surgery'],function(){
            Route::post('cancel',[\App\Http\Controllers\v1\patient_system\surgery\SurgeryController::class,'cancel']);
            Route::resource('resource',\App\Http\Controllers\v1\patient_system\surgery\SurgeryController::class);
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
    //Inventory System
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
        Route::get('/orderers',function(){
            return \App\Models\inventory_system\Orderer::all();
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
        Route::get('/out/show_by_service_id/{service_id}',[\App\Http\Controllers\V1\inventory_system\out\OutController::class,'show_by_service_id']);
        //low_stock
        Route::get('low_stock',[\App\Http\Controllers\V1\inventory_system\low_stock\LowStockController::class,'list']);
        //inventory_service
        //Route::get('/item/count_low_stock',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'count_low_stock']);
        //item
        Route::post('/item/update_auth',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'update_auth']);
        Route::post('/item/inventory/update',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'update_inventory']);
        Route::get('/item/count_per_type',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'count_per_type']);
        Route::get('item/code',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'getCode']);
        Route::get('item/get_by_barcode/{barcode}',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'get_by_barcode']);
        Route::get('/item/authorized_service/{service_name}',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'where_authorized_service']);
        Route::resource('item',\App\Http\Controllers\V1\inventory_system\item\ItemController::class);
        Route::post('/item/stock_check',[\App\Http\Controllers\V1\inventory_system\item\ItemController::class,'check_stock_avalaibility']);
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
    //extra
    Route::group(['prefix'=>'extra'],function(){
        //cars
        Route::resource('car',\App\Http\Controllers\V1\System\CarController::class);
        //Medical center
        Route::resource('medical_center',\App\Http\Controllers\V1\System\MedicalCenterController::class);
        //employee
        Route::resource('employee',\App\Http\Controllers\V1\System\EmployeeController::class);
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
        // additional screening reasons
        Route::get('ultrasound_additional_screening_reasons',function() {
            return \App\Models\UltrasoundAdditionalScreeningReason::all();
        });
        // login check
        Route::group(['prefix'=> 'auth'], function() {
            Route::post('/credentials', [\App\Http\Controllers\v1\System\Auth\CredentialController::class,'check']);
        });
        //Cervix consistency
        Route::get('cervix_consistency',function(){
            return \App\Models\CervixConsistency::all();
        });
        //stork actions
        Route::get('stork_action_group',function(){
            return \App\Models\StorkActionGroup::all();
        });
        //Bed
        Route::get('bed/{occupied}',function($occupied){
            return \App\Models\Bed::where('occupied',$occupied)->get();
        });

    });
});
