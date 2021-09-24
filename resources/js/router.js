import Vue from 'vue'
import VueRouter from 'vue-router';


//Auth
import login from "./views/auth/login"

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
import cpn_followup from "./views/medical/obstetrics/cpn/cpn_followup";
import first_cpn_list from "./views/medical/obstetrics/cpn/first_cpn_list";
import pregnancy_test from "./views/medical/obstetrics/cpn/pregnancy_test";
import ultrasound_form from "./views/medical/obstetrics/ultrasound/ultrasound_form";
import ultrasound_list from "./views/medical/obstetrics/ultrasound/ultrasound_list";
import weight_overview from "./views/medical/obstetrics/baby/weight_overview";
import baby_checkup from "./views/medical/obstetrics/baby/baby_checkup";
import baby_checkup_list from "./views/medical/obstetrics/baby/baby_checkup_list";
import baby_vaccination_card from "./views/medical/obstetrics/baby/baby_vaccination_card";
import baby_vaccination_list from "./views/medical/obstetrics/baby/baby_vaccination_list";
//Overview
import overview_layout from "./views/medical/overview/layouts/overview_layout";
import obstetrics_overview from "./views/medical/overview/obstetrics_overview";
//maternity

import maternity_layout from "./views/medical/maternity/layouts/maternity_layout"
import maternity_admission from "./views/medical/maternity/maternity_admission";
import delivery_registration from "./views/medical/maternity/delivery/delivery_registration";
import maternity_in_patient_list from "./views/medical/maternity/in_patient/maternity_in_patient_list"
import delivery_book from "./views/medical/maternity/delivery/delivery_book";
import birth_certificate from "./views/medical/maternity/delivery/birth_certificate";
import in_patient_data_entry from "./views/medical/maternity/in_patient/in_patient_data_entry";
import medical_appreciation_details from "./views/medical/maternity/in_patient/medical_appreciation_details";
import external_referral from "./views/medical/maternity/referral/external_referral";
import internal_referral from "./views/medical/maternity/referral/internal_referral";
import maternity_discharge from "./views/medical/maternity/maternity_discharge";
import laboratory_request from "./views/medical/laboratory/laboratory_request";
import maternity_labwork from "./views/medical/maternity/labwork/maternity_labwork";
//generalist
import generalist_layout from "./views/medical/generalist/layouts/generalist_layout";
import generalist_list from "./views/medical/generalist/generalist_list";
import generalist_consultation from "./views/medical/generalist/generalist_consultation";
import medical_form_layout from "./components/medical_form_layout";
//inventory_system
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
            //
            {
                path: 'maternity_admission',
                name: "joycenter.maternity_admission",
                component: maternity_admission
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
                meta: { title : 'CPN' }
            },
            {
                path: 'admission/:id?',
                name: 'cpn_admission',
                component: cpn_admission
            },
            {
                path: 'followup',
                name: 'cpn_followup',
                component: cpn_followup,
                meta : { title: 'CPN Followup' }
            },
            {
                path: 'pregnancy_test',
                name: 'pregnancy_test',
                component: pregnancy_test
            },
            {
                path: 'ultrasound_form/:ref?',
                name: 'ultrasound_form',
                component: ultrasound_form
            },
            {
                path: 'ultrasound_list',
                name: 'ultrasound_list',
                component: ultrasound_list,
                meta: { title : 'Ultrasound' }
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


        ]
    },

    /**
     |-----------------------------
     | Maternity
     |-----------------------------
     */
    {
        path:'/maternity',
        name:'maternity_home',
        component:maternity_layout,
        children:[
            {
                path:'admission',
                name:'maternity_admission',
                component: maternity_admission
            },
            //list of in_patient
            {
                path:'in_patient_list',
                name:'maternity_in_patient_list',
                component:maternity_in_patient_list
            },
            {
                path:'data_entry',
                name:'in_patient_data_entry',
                component:in_patient_data_entry
            },
            {
                path:'medical_appreciation_details',
                name:'medical_appreciation_details',
                component:medical_appreciation_details
            },
            {
                path:'delivery/registration',
                name:'delivery_registration',
                component:delivery_registration
            },
            {
                path:'delivery/birth_certificate',
                name:'birth_certificate',
                component:birth_certificate
            },
            {
                path:'delivery/delivery_book',
                name:'delivery_book',
                component:delivery_book
            },
            {
                path:'referral/external',
                name:'external_referral',
                component: external_referral
            },
            {
                path:'referral/internal',
                name:'internal_referral',
                component: internal_referral
            },
            {
                path:'discharge',
                name:'maternity_discharge',
                component: maternity_discharge
            },
            {
                path:'laboratory/request',
                name:'maternity_labwork',
                component: maternity_labwork
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
