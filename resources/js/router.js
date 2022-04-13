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
import obstetrics_layout from "./views/medical/obstetrics/layouts/obstetrics_layout";

//Overview
import overview_layout from "./views/medical/overview/layouts/overview_layout";
import obstetrics_overview from "./views/medical/overview/obstetrics_overview";
//In patient
    //stork Center
    import stork_layout from "./views/medical/in_patient/stork_center/layouts/stork_layout";
    import stork_admission from "./views/medical/in_patient/stork_center/stork_admission";
    import stork_incoming_patient from "./views/medical/in_patient/stork_center/stork_incoming_patient";
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
//Baby
import weight_overview from "./views/medical/obstetrics/baby/weight_overview";
import baby_checkup from "./views/medical/obstetrics/baby/baby_checkup";
import baby_checkup_list from "./views/medical/obstetrics/baby/baby_checkup_list";
import baby_vaccination_card from "./views/medical/obstetrics/baby/baby_vaccination_card";
import baby_vaccination_list from "./views/medical/obstetrics/baby/baby_vaccination_list";
import baby_milk_pro_admission from "./views/medical/obstetrics/baby/baby_milk_pro_admission";
import baby_milk_pro_followup from "./views/medical/obstetrics/baby/baby_milk_pro_followup";
import baby_milk_pro_list from "./views/medical/obstetrics/baby/baby_milk_pro_list";
//Family planning
import family_planning_list from "./views/medical/obstetrics/family_planning/family_planning_list";
import family_planning_form from "./views/medical/obstetrics/family_planning/family_planning_form";
//item order obstetrics
import item_order_obstetrics from "./views/medical/obstetrics/item_order_obstetrics";
//report Pink statistics
import pink_statistics from "./views/medical/obstetrics/report/pink_statistics";

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

            }
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
                path: 'baby_vaccination_list',
                name: 'baby_vaccination_list',
                component:baby_vaccination_list,
                meta: { title : 'Baby vaccination' }
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
                path:'incoming_patient',
                name:'stork_incoming_patient',
                component: stork_incoming_patient
            },



        ]
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
            }
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
