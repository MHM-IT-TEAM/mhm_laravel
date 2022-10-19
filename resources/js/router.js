import Vue from 'vue'
import VueRouter from 'vue-router';


//Auth
import login from "./views/auth/login"
//Admin
import admin_layout from "./views/admin/layouts/admin_layout";
import user_page_overview from "./views/admin/user_page_overview";
import users_crud from "./views/admin/users_crud";
import pages from "./views/admin/pages";
import admin_statistic from "./views/admin/admin_statistic";
//landing Page
import welcome from "./views/home/welcome";

//joyCenter
import joyLayout from "./views/joyCenter/layouts/joyLayout";
import joyWelcome from "./views/joyCenter/admission/joyWelcome";
import patient_crud from "./views/patient/patient_crud";
import admission from "./views/joyCenter/admission/admission";
import admission_list from "./views/joyCenter/admission/admissionList";
//Cashier
import cashier_layout from "./views/cashier/layouts/cashier_layout";
import cashier_admission_list from "./views/cashier/cashier_admission_list";
import cashier_payment from "./views/cashier/cashier_payment";



//Obstetrics
import cpn_admission from "./views/medical/obstetrics/cpn/cpn_admission";
import new_cpn_admission from "./views/medical/obstetrics/cpn/new_cpn_admission";
import obstetrics_layout from "./views/medical/obstetrics/layouts/obstetrics_layout";
import obstetrics_view_internal_lab_result from "./views/medical/obstetrics/obstetrics_view_internal_lab_result";

//Overview
import overview_layout from "./views/medical/overview/layouts/overview_layout";
import obstetrics_overview from "./views/medical/overview/obstetrics_overview";
//In patient
    //stork Center
    import stork_layout from "./views/medical/in_patient/stork_center/layouts/stork_layout";
    import stork_admission from "./views/medical/in_patient/stork_center/stork_admission";
    import stork_incoming_patient from "./views/medical/in_patient/stork_center/stork_incoming_patient";
    import stork_patient_list from "./views/medical/in_patient/stork_center/stork_patient_list";
    import pregnancy_checkup_form from "./views/medical/in_patient/stork_center/pregnancy_checkup_form";
    import stork_balance_list from "./views/medical/in_patient/stork_center/stork_balance_list";
    import balance_sheet from "./views/medical/in_patient/stork_center/balance_sheet";
    import stork_vital_signs from "./views/medical/in_patient/stork_center/stork_vital_signs";
    import stork_give_medicine from "./views/medical/in_patient/stork_center/stork_give_medicine";
    import stork_internal_consultation from "./views/medical/in_patient/stork_center/stork_internal_consultation";
    import stork_external_consultation from "./views/medical/in_patient/stork_center/stork_external_consultation";
    import stork_dismissal from "./views/medical/in_patient/stork_center/stork_dismissal";
    import stork_pregnancy_card_search from "./views/medical/in_patient/stork_center/stork_pregnancy_card_search";
    import stork_patient_list_of_cpn from "./views/medical/in_patient/stork_center/stork_patient_list_of_cpn";
    import in_patient_book from "./views/medical/in_patient/in_patient_book";
    import stork_order from "./views/medical/in_patient/stork_center/stork_order";
    import stork_internal_labwork from "./views/medical/in_patient/stork_center/stork_internal_labwork";
    import stork_diagnose from "./views/medical/in_patient/stork_center/stork_diagnose";
    import stork_external_referal from "./views/medical/in_patient/stork_center/referral/stork_external_referal";
    import stork_internal_referral from "./views/medical/in_patient/stork_center/referral/stork_internal_referral";
    import external_referral_book from "./views/medical/in_patient/stork_center/referral/external_referral_book";
    import stork_wound_care from "./views/medical/in_patient/stork_center/stork_wound_care";
    import stork_mobilisation from "./views/medical/in_patient/stork_center/stork_mobilisation";
    import stork_body_care from "./views/medical/in_patient/stork_center/stork_body_care";
    import stork_medical_care from "./views/medical/in_patient/stork_center/stork_medical_care";
    import stork_weekly_measurments from "./views/medical/in_patient/stork_center/stork_weekly_measurments";
    import stork_internal_lab_list from "./views/medical/in_patient/stork_center/stork_internal_lab_list";
    import stork_view_internal_lab_result from "./views/medical/in_patient/stork_center/stork_view_internal_lab_result";
    import stork_supply_list from "./views/medical/in_patient/stork_center/stork_supply_list";
    import stork_pay_lunch from "./views/medical/in_patient/stork_center/stork_pay_lunch";
    import stork_additional_consult from "./views/medical/in_patient/stork_center/stork_additional_consult";
    import bed_overview from "./views/medical/in_patient/stork_center/overview/bed_overview";

//Delivery
    import delivery_layout from "./views/medical/delivery/layouts/delivery_layout";
    import delivery_registration from "./views/medical/delivery/delivery_registration";
    import birth_certificate from "./views/medical/delivery/birth_certificate";
    import delivery_book from "./views/medical/delivery/delivery_book";
    import delivery_decision_request from "./views/medical/delivery/delivery_decision_request";
    import delivery_pregnancy_card_search from "./views/medical/delivery/delivery_pregnancy_card_search";
    import delivery_patient_list_of_cpn from "./views/medical/delivery/delivery_patient_list_of_cpn";
    import delivery_order from "./views/medical/delivery/delivery_order";
    import delivery_supply_list from "./views/medical/delivery/delivery_supply_list";
// Surgery
    import surgery_layout from "./views/medical/surgery/surgery_layout";
    import pre_surgery_list from "./views/medical/surgery/pre_surgery_list";
    import surgery_list from "./views/medical/surgery/surgery_list";
    import pre_surgery_form from "./views/medical/surgery/pre_surgery_form";
    import surgery_form from "./views/medical/surgery/surgery_form";

// import maternity_layout from "./views/medical/maternity/layouts/maternity_layout"
// import maternity_admission from "./views/medical/maternity/maternity_admission";
// import delivery_registration from "./views/medical/maternity/delivery/delivery_registration";
// import maternity_in_patient_list from "./views/medical/maternity/in_patient/maternity_in_patient_list"
// import maternity_incoming_patient from "./views/medical/maternity/in_patient/maternity_incoming_patient";
// import in_patient_admission from "./views/medical/maternity/in_patient/in_patient_admission";
// import delivery_book from "./views/medical/maternity/delivery/delivery_book";
// import birth_certificate from "./views/medical/maternity/delivery/birth_certificate";
// import in_patient_data_entry from "./views/medical/maternity/in_patient/in_patient_data_entry";
// import medical_appreciation_details from "./views/medical/maternity/in_patient/medical_appreciation_details";
// import external_referral from "./views/medical/maternity/referral/external_referral";
// import internal_referral from "./views/medical/maternity/referral/internal_referral";
// import maternity_discharge from "./views/medical/maternity/maternity_discharge";
// import maternity_labwork from "./views/medical/maternity/labwork/maternity_labwork";
// import maternity_list from "./views/medical/maternity/maternity_list";
//generalist
import laboratory_request from "./views/medical/laboratory/laboratory_request";
import generalist_layout from "./views/medical/generalist/layouts/generalist_layout";
import generalist_list from "./views/medical/generalist/generalist_list";
import generalist_consultation from "./views/medical/generalist/generalist_consultation";
import generalist_internal_lab_list from "./views/medical/generalist/generalist_internal_lab_list";
import item_order_generalist from "./views/medical/generalist/item_order_generalist";
import generalist_view_internal_lab_result from "./views/medical/generalist/generalist_view_internal_lab_result";
import medical_form_layout from "./components/medical_form_layout";
//dentist
import dentist_layout from "./views/medical/dentist/layouts/dentist_layout"
import dentist_patient_list from "./views/medical/dentist/dentist_patient_list";
import dental_diagnostic_form from "./views/medical/dentist/dental_diagnostic_form";
import item_order_dentist from "./views/medical/dentist/item_order_dentist";
// Woundcare
import wound_care_layout from "./views/medical/woundcare/layout/wound_care_layout";
import wound_care_form from "./views/medical/woundcare/wound_care_form";
import woundcare_list from "./views/medical/woundcare/woundcare_list";
//inventory_system
//Nurse station
import nurse_station_layout from "./views/medical/nurse_station/layout/nurse_station_layout";
import inventory_welcome from "./views/inventory_management/inventory_welcome";
import inventory_layout_base from "./views/inventory_management/layouts/inventory_layout_base";
import inventory_dashboard from "./views/inventory_management/inventory_dashboard";
import create from "./views/inventory_management/item/create";
import item_index from "./views/inventory_management/item/item_index";
import out_form from "./views/inventory_management/out/out_form";
import out_list from "./views/inventory_management/out/out_list";
import low_stock from "./views/inventory_management/item/low_stock";
import cart_list from "./views/inventory_management/cart/cart_list";
import cart_form from "./views/inventory_management/cart/cart_form";
import in_list from "./views/inventory_management/IN/in_list";
import in_form from "./views/inventory_management/IN/in_form";
import inventory_book from "./views/inventory_management/inventory/inventory_book";
import item_authorization from "./views/inventory_management/item/item_authorization";
import labwork_list from "./views/medical/nurse_station/labwork_list";
import internal_lab from "./views/medical/labwork/internal/internal_lab";
import nurse_view_internal_lab_result from "./views/medical/nurse_station/nurse_view_internal_lab_result";
//Grace center
import grace_center_layout from "./views/medical/grace_center/grace_center_layout";
import list_of_patient_grace from "./views/medical/grace_center/list_of_patient_grace";
import grace_give_medicine from "./views/medical/grace_center/grace_give_medicine"
import item_order_grace from "./views/medical/grace_center/item_order_grace";
import grace_inventory from "./views/medical/grace_center/grace_inventory";
//ultrasound_1
import ultrasound_layout from "./views/medical/obstetrics/ultrasound_1/ultrasound_layout";
import ultrasound_exam_crud from "./views/medical/obstetrics/ultrasound_1/ultrasound_exam_crud";
import ultrasound_queue from "./views/medical/obstetrics/ultrasound_1/ultrasound_queue";
import ultrasound_admission_form from "./views/medical/obstetrics/ultrasound_1/ultrasound_admission_form";
import patient_ultrasound_admission_list  from "./views/medical/obstetrics/ultrasound_1/patient_ultrasound_admission_list";
import patient_ultrasound_search from "./views/medical/obstetrics/ultrasound_1/patient_ultrasound_search";
import item_order_ultrasound from "./views/medical/obstetrics/ultrasound_1/item_order_ultrasound";
//CPN
import patient_cpn_search from "./views/medical/obstetrics/cpn/patient_cpn_search";
import pregnancy_card from "./views/medical/obstetrics/pregnancy_card";
import patient_list_of_cpn from "./views/medical/obstetrics/cpn/patient_list_of_cpn";
import cpn_followup from "./views/medical/obstetrics/cpn/cpn_followup";
import first_cpn_list from "./views/medical/obstetrics/cpn/first_cpn_list";
import cpn_followup_list from "./views/medical/obstetrics/cpn/cpn_followup_list";
import cpn_internal_lab_list from "./views/medical/obstetrics/cpn/cpn_internal_lab_list";
// POSTPARTUM
import postpartum_list from "./views/medical/obstetrics/postpartum/postpartum_list";
import postpartum_form from "./views/medical/obstetrics/postpartum/postpartum_form";
//Baby
import weight_overview from "./views/medical/obstetrics/baby/weight_overview";
import baby_checkup from "./views/medical/obstetrics/baby/baby_checkup";
import baby_checkup_list from "./views/medical/obstetrics/baby/baby_checkup_list";
import baby_vaccination_card from "./views/medical/obstetrics/baby/baby_vaccination_card";
import baby_vaccination_list from "./views/medical/obstetrics/baby/baby_vaccination_list";
import baby_milk_pro_admission from "./views/medical/obstetrics/baby/baby_milk_pro_admission";
import baby_milk_pro_followup from "./views/medical/obstetrics/baby/baby_milk_pro_followup";
import baby_milk_pro_list from "./views/medical/obstetrics/baby/baby_milk_pro_list";
import baby_sickness from "./views/medical/obstetrics/baby/baby_sickness";
import baby_sickness_list from "./views/medical/obstetrics/baby/baby_sickness_list";
import baby_internal_lab_list from "./views/medical/obstetrics/baby/baby_internal_lab_list";
//Family planning
import family_planning_list from "./views/medical/obstetrics/family_planning/family_planning_list";
import family_planning_form from "./views/medical/obstetrics/family_planning/family_planning_form";
//item order obstetrics
import item_order_obstetrics from "./views/medical/obstetrics/item_order_obstetrics";
//report Pink statistics
import pink_statistics from "./views/medical/obstetrics/report/pink_statistics";
import cashier_lunch_payment_list from "./views/cashier/cashier_lunch_payment_list";



Vue.use(VueRouter);

const routes = [
    /**
     |-----------------------
     | Landing Page
     |------------------------
    */
    {
        name:'landing_page',
        path:'/',
        component: welcome
    },


    /**
     |----------------------------
     | Auth and Registration form
     |----------------------------
     */
    {
        name:'login',
        path:'/login',
        component:login

    },
    /**
     |---------------------------
     | Admin
     |--------------------------
     */
    {
        name:'admin',
        path:'/admin',
        component:admin_layout,
        children: [
            //user_page_overview
            {
                path:'user_page_overview',
                name:'admin_user_page_overview',
                component: user_page_overview
            },
            //User CRUD
            {
                path:'user_crud',
                name:'admin_user_crud',
                component:users_crud
            },
            //Pages CRUD
            {
                path:'page_crud',
                name:'admin_page_crud',
                component:pages
            },
            //Statistics Page
            {
                path:'admin_statistics',
                name:'admin_statistics',
                component:admin_statistic
            }
        ]

    },

    /**
    |---------------------------
     | joyCenter
     |--------------------------
     */
    {
        path: "/joyCenter",
        name: "joyHome",
        component: joyLayout,
        children: [
            //home
            {
                path:'welcome',
                name:'joyWelcome',
                component:joyWelcome

            },
            //patient
            {
                path: 'patients/crud',
                name: "patients.crud",
                component: patient_crud
            },
            //consultation
            {
                path: 'admission',
                name: "admission.new",
                component: admission
            },
            //queue list
            {
                path: 'admission_list',
                name: "admission.list",
                component: admission_list
            },
        ]
    },
    /**
     /-------------------
        Cashier
     /-------------------
     */
    {
        path:'/cashier',
        name:'cashier',
        component: cashier_layout,
        children: [
            {
                path:'admission_list',
                name:'cashier_admission_list',
                component: cashier_admission_list

            },
            {
                path:'payment',
                name:'cashier_payment',
                component: cashier_payment

            },
            {
                path:'lunch_payment_list',
                name:'cashier_lunch_payment_list',
                component:cashier_lunch_payment_list
            },

        ]
    },
    /**
     |-----------------------------
     | Inventory system
     |-----------------------------
     */{
         path:'/inventory_system',
        name:'inventory_system',
        component: inventory_layout_base,
        children: [
            {
                path:'dashboard',
                name:'inventory_dashboard',
                component:inventory_dashboard
            },
            {
                path:'item/index',
                name:'item_index',
                component:item_index,
            },
            {
                path:'item/create',
                name:'item_create',
                component:create,
            },
            {
                path:'item/low_stock',
                name:'low_stock',
                component:low_stock,
            },
            {
                path:'item/authorization',
                name:'item_authorization',
                component:item_authorization,
            },
            //out
            {
                path:'out/create',
                name:'out_create',
                component:out_form
            },
            {
                path:'out/list',
                name:'out_list',
                component:out_list,
            },
            //shopping cart
            {
                path:'cart',
                name:'cart_list',
                component:cart_list,
            },
            {
                path:'cart/form',
                name:'cart_form',
                component:cart_form
            },
            //IN
            {
                path:'in/list',
                name:'in_list',
                component: in_list
            },
            {
                path:'in/form',
                name:'in_form',
                component: in_form
            },
            {
                path:'inventory',
                name:'inventory_book',
                component:inventory_book
            }
        ]
    },

  /**
   |-----------------------------
    | Obstetrics
   |-----------------------------
   */
    {
        path: '/obstetrics',
        name: 'obstetrics_home',
        component: obstetrics_layout,
        children: [
            {
                path:'cpn/admission/new',
                name:'new_cpn_admission',
                component:new_cpn_admission
            },
            {
                path: 'first_cpn_list',
                name: 'first_cpn_list',
                component: first_cpn_list,
                meta: { title : 'Prenatal Care First Checkup' }
            },
            {
                path: 'admission/:id?',
                name: 'cpn_admission',
                component: cpn_admission
            },
            {
                path: 'cpn_followup_list',
                name: 'cpn_followup_list',
                component: cpn_followup_list,
                meta: { title : 'Prenatal Care Followup' }
            },
            {
                path:'cpn_internal_lab_list',
                name:'cpn_internal_lab_list',
                component:cpn_internal_lab_list
            },
            {
                path: 'cpn_followup/:cpn_ref?',
                name: 'cpn_followup',
                component: cpn_followup
            },
            {
                path:'pregnancy_card',
                name:'pregnancy_card',
                component:pregnancy_card
            },
            {
                path:'list_of_cpn',
                name:'patient_list_of_cpn',
                component:patient_list_of_cpn
            },
            {
                path:'cpn_search',
                name:'patient_cpn_search',
                component:patient_cpn_search
            },
            {
                path: 'baby_weight_overview',
                name: 'baby_weight_overview',
                component:weight_overview
            },
            {
                path: 'baby_checkup_list',
                name: 'baby_checkup_list',
                component:baby_checkup_list,
                meta: { title : 'Baby checkup' }
            },
            {
                path: 'baby_checkup',
                name: 'baby_checkup',
                component:baby_checkup
            },
            {
                path: 'baby_sickness_list',
                name: 'baby_sickness_list',
                component:baby_sickness_list
            },
            {
                path: 'baby_sickness',
                name: 'baby_sickness',
                component:baby_sickness
            },

            {
                path: 'baby_vaccination_list',
                name: 'baby_vaccination_list',
                component:baby_vaccination_list,
                meta: { title : 'Baby vaccination' }
            },
            {
                path:'baby_internal_lab_list',
                name:'baby_internal_lab_list',
                component:baby_internal_lab_list
            },
            {
                path: 'baby_vaccination_card',
                name: 'baby_vaccination_card',
                component:baby_vaccination_card
            },
            {
                path: 'milk_pro_admission',
                name: 'milk_pro_admission',
                component:baby_milk_pro_admission
            },
            {
                path: 'milk_pro_followup',
                name: 'milk_pro_followup',
                component:baby_milk_pro_followup
            },
            {
                path: 'milk_pro_list',
                name: 'milk_pro_list',
                component:baby_milk_pro_list
            },
            //family planning
            {
                path:'family_planning_list',
                name:'family_planning_list',
                component:family_planning_list
            },
            {
                path:'family_planning_form',
                name:'family_planning_form',
                component:family_planning_form
            },
            //item order
            {
                path:'order',
                name:'item_order_obstetrics',
                component:item_order_obstetrics
            },
            //pink statistics
            {
                path:'report',
                name:'pink_statistics',
                component:pink_statistics
            },
            //postpartum
            {
                path:'postpartum_list',
                name:'postpartum_list',
                component:postpartum_list
            },
            {
                path:'postpartum_form',
                name:'postpartum_form',
                component:postpartum_form
            },
            {
                path:'internal_lab/result',
                name:'obstetrics_view_internal_lab_result',
                component: obstetrics_view_internal_lab_result
            }
        ]
    },

    /**
     |-----------------------------
     | stork center
     |-----------------------------
     */
    {
        path:'/stork',
        name:'stork_center',
        component:stork_layout,
        children:[
            {
                path:'admission',
                name:'stork_admission',
                component: stork_admission
            },
            {
                path:'request',
                name:'stork_request',
                component: stork_incoming_patient
            },
            {
                path:'patient_list',
                name:'stork_patient_list',
                component: stork_patient_list
            },
            //diagnostic
                //Pregnancy checkup form
            {
                path:'diagnostic/pregnancy_checkup',
                name:'stork_diagnostic_pregnancy_checkup',
                component: pregnancy_checkup_form
            },
            {
                path:'diagnose',
                name:'stork_diagnose',
                component: stork_diagnose
            },
            {
                path:'diagnostic/balance_list',
                name:'stork_diagnostic_balance_list',
                component: stork_balance_list
            },
            {
                path:'diagnostic/balance',
                name:'stork_diagnostic_balance',
                component: balance_sheet
            },
            {
                path:'diagnostic/vital_signs',
                name:'stork_vital_signs',
                component: stork_vital_signs
            },
            //treatment
            {
                path:'treatment/medicines',
                name:'stork_give_medicine',
                component: stork_give_medicine
            },
            {
                path:'treatment/wound_care',
                name:'stork_wound_care',
                component: stork_wound_care
            },
            {
                path:'treatment/mobilisation',
                name:'stork_mobilisation',
                component: stork_mobilisation
            },
            {
                path:'treatment/body_care',
                name:'stork_body_care',
                component: stork_body_care
            },
            {
                path:'treatment/medical_care',
                name:'stork_medical_care',
                component: stork_medical_care
            },
            {
                path:'treatment/internal_consulation',
                name:'stork_internal_consultation',
                component: stork_internal_consultation
            },
            {
                path:'treatment/external_consultation',
                name:'stork_external_consultation',
                component: stork_external_consultation
            },
            {
                path:'dismissal',
                name:'stork_dismissal',
                component: stork_dismissal
            },
            {
                path:'external_referral',
                name:'stork_external_referral',
                component: stork_external_referal
            },
            {
                path:'internal_referral',
                name:'stork_internal_referral',
                component: stork_internal_referral
            },
            {
                path:'external_referral_book',
                name:'stork_external_referral_book',
                component: external_referral_book
            },
            {
                path:'in_patient_book',
                name:'in_patient_book',
                component: in_patient_book
            },
            {
                path:'order',
                name:'stork_order',
                component: stork_order
            },
            {
                path:'internal_lab',
                name:'stork_internal_lab',
                component: stork_internal_labwork
            },
            {
                path:'weekly_measurments',
                name:'stork_weekly_measurments',
                component: stork_weekly_measurments
            },
            {
                path:'internal_lab_list',
                name:'stork_internal_lab_list',
                component:stork_internal_lab_list
            },
            {
                path:'internal_lab_result',
                name:'stork_view_internal_lab_result',
                component:stork_view_internal_lab_result
            },
            {
                path:'supply_list',
                name:'stork_supply_list',
                component:stork_supply_list
            },
            {
                path:'lunch',
                name:'stork_pay_lunch',
                component:stork_pay_lunch
            },
            {
                path:'additional_consultation',
                name:'stork_additional_consultation',
                component:stork_additional_consult
            },
            {
                path:'bed_overview',
                name:'stork_bed_overview',
                component:bed_overview
            }
        ]
    },
    /**
     |-----------------------------
     | Surgery
     |-----------------------------
     */
    {
        path:'/surgery',
        name:'surgery_layout',
        component: surgery_layout,
        children:[
            {
                path:'pre_list',
                name:'pre_surgery_list',
                component:pre_surgery_list

            },
            {
                path:'pre_surgery_form',
                name:'pre_surgery_form',
                component:pre_surgery_form

            },
            {
                path:'form',
                name:'surgery_form',
                component:surgery_form

            },
            {
                path:'form/:id',
                name:'surgery_form_edit',
                component:surgery_form

            },
            {
                path:'pre_surgery_form/:id',
                name:'pre_surgery_form',
                component:pre_surgery_form

            },
            {
                path:'list',
                name:'surgery_list',
                component:surgery_list

            },

        ]
    },

    /**
     |-----------------------------
     | Delivery
     |-----------------------------
     */
    {
        path:'/delivery',
        name:'delivery_layout',
        component:delivery_layout,
        children:[
            {
                path:'registration',
                name:'delivery_registration',
                component: delivery_registration
            },
            {
                path:'certificate',
                name:'birth_certificate',
                component: birth_certificate
            },
            {
                path:'pregnancy_card',
                name:'delivery_pregnancy_card',
                component:pregnancy_card
            },
            {
                path:'cpn_list',
                name:'delivery_patient_list_of_cpn',
                 component:delivery_patient_list_of_cpn
            },
            {
                path:'delivery_book',
                name:'delivery_book',
                component:delivery_book
            },
            {
                path:'decision_request',
                name:'delivery_decision_request',
                component:delivery_decision_request
            },
            {
                path:'delivery_pregnancy_card',
                name:'delivery_pregnancy_card_search',
                component:delivery_pregnancy_card_search
            },
            {
                path:'supplies',
                name:'delivery_supply_order',
                component:delivery_order
            },
            {
                path:'supply_list',
                name:'delivery_supply_list',
                component:delivery_supply_list
            }

        ],
    },

    /**
     |-----------------------------
     | Generalist
     |-----------------------------
     */

    {
        path:'/generalist',
        component:generalist_layout,
        children: [
            {
                path:'patient_list',
                name:'generalist_patient_list',
                component:generalist_list
            },
            {
                path:'generalist_consultation',
                name:'generalist_consultation',
                component:generalist_consultation
            },
            {
                path:'generalist_internal_lab_list',
                name:'generalist_internal_lab_list',
                component:generalist_internal_lab_list
            },
            {
                path:'item_order',
                name:'generalist_item_order',
                component:item_order_generalist
            },
            {
                path:'internal_lab_result',
                name:'generalist_view_internal_lab_result',
                component:generalist_view_internal_lab_result
            },
        ]
    },
    /**
     |-----------------------------
     | WoundCare
     |-----------------------------
     */
    {
        path:'/woundcare',
        component:wound_care_layout,
        children:[
            {
                path:'list',
                name:'wound_care_list',
                component:woundcare_list
            },
            {
                path:'form',
                name:'wound_care_form',
                component:wound_care_form
            }
        ]
    },

    /**
     |-----------------------------
     | Dentist
     |-----------------------------
     */
    {
        path:'/dentist',
        component:dentist_layout,
        children:[
            {
                path:'patient_list',
                name:'dentist_patient_list',
                component: dentist_patient_list
            },
            {
                path:'diagnostic',
                name:'dental_diagnostic_form',
                component: dental_diagnostic_form
            },
            {
                path:'item_order',
                name:'dentist_item_order',
                component:item_order_dentist
            },
        ]
    },
    /**
     |-----------------------------
     | Nurse station
     |-----------------------------
     */
    {
        path:'/nurse_station',
        component:nurse_station_layout,
        children:[
            {
                path:'lab_work_list',
                name:'lab_work_list',
                component:labwork_list
            },
            {
                path:'internal_lab_form',
                name:'internal_lab_form',
                component: internal_lab
            },
            {
                path:'internal_lab_result',
                name:'nurse_view_internal_lab_result',
                component: nurse_view_internal_lab_result
            }
        ]

    },
    /**
     |-----------------------------
     | Grace Center
     |-----------------------------
     */
    {
        path:'/grace_center',
        component:grace_center_layout,
        children:[
            {
                name:'grace_patient_list',
                path:'patient_list',
                component: list_of_patient_grace
            },
            {
                name:'grace_give_medicine',
                path:'give_medicine',
                component: grace_give_medicine
            },
            {
                name:'item_order_grace',
                path:'order',
                component: item_order_grace
            },
            {
                name:'grace_inventory',
                path:'inventory',
                component: grace_inventory
            }
        ]
    },
    /**
     |-----------------------------
     | Ultrasound_1
     |-----------------------------
     */
    {
        path:'/ultrasound',
        name:'ultrasound_layout',
        component:ultrasound_layout,
        children: [
            {
                path:'exam_crud',
                name:'ultrasound_exam_crud',
                component:ultrasound_exam_crud
            },
            {
                path:'queue',
                name:'ultrasound_queue',
                component:ultrasound_queue
            },
            {
                path:'admission_form',
                name:'ultrasound_admission_form',
                component:ultrasound_admission_form
            },
            {
                path:'admission_list',
                name:'patient_ultrasound_admission_list',
                component:patient_ultrasound_admission_list
            },
            {
                path:'patient_ultrasound',
                name:'patient_ultrasound_search',
                component:patient_ultrasound_search
            },
            {
                path:'order',
                name:'item_order_ultrasound',
                component:item_order_ultrasound
            },
        ]
    },

    /**
     |-----------------------------
     | Overviews
     |-----------------------------
     */
    {
        path:'/overview',
        name:'obstetrics_overview',
        component:overview_layout,
        children:[
            {
                path:'obstetrics',
                name:'obstetrics_overview',
                component:obstetrics_overview,

            }
        ]
    },
    {
        path:'/laboratory/request',
        name:'laboratory_request',
        component: laboratory_request
    }

];

const router = new VueRouter({
    routes,
    mode: 'history'
})



export default router;
