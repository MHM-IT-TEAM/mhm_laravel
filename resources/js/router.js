import Vue from 'vue'
import VueRouter from 'vue-router';


//Auth
import login from "./views/auth/login"

//landing Page
import welcome from "./views/home/welcome";

//joyCenter
import joyLayout from "./views/joyCenter/layouts/joyLayout";
import joyWelcome from "./views/joyCenter/consultation/joyWelcome";
import patientSearch from "./components/patient/patientSearch";
import consultation from "./views/joyCenter/consultation/consultation";
import queue from "./views/joyCenter/consultation/queue";


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
//maternity

import maternity_layout from "./views/medical/maternity/layouts/maternity_layout"
import maternity_admission from "./views/medical/maternity/maternity_admission";


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
                component: patientSearch
            },
            //consultation
            {
                path: 'consultation',
                name: "consultation.new",
                component: consultation
            },
            //queue list
            {
                path: 'queueList',
                name: "consultation.list",
                component: queue
            },
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
                component: first_cpn_list

            },
            {
                path: 'admission',
                name: 'cpn_admission',
                component: cpn_admission
            },
            {
                path: 'followup',
                name: 'cpn_followup',
                component: cpn_followup
            },
            {
                path: 'pregnancy_test',
                name: 'pregnancy_test',
                component: pregnancy_test
            },
            {
                path: 'ultrasound_form',
                name: 'ultrasound_form',
                component: ultrasound_form
            },
            {
                path: 'ultrasound_list',
                name: 'ultrasound_list',
                component: ultrasound_list
            },
            {
                path: 'baby_weight_overview',
                name: 'baby_weight_overview',
                component:weight_overview
            },
            {
                path: 'baby_checkup_list',
                name: 'baby_checkup_list',
                component:baby_checkup_list
            },
            {
                path: 'baby_checkup',
                name: 'baby_checkup',
                component:baby_checkup
            },
            {
                path: 'baby_vaccination_list',
                name: 'baby_vaccination_list',
                component:baby_vaccination_list
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
            }
        ]
    },

];

const router = new VueRouter({
    routes,
    mode: 'history'
})



export default router;
