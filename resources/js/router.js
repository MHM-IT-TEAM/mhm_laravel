import Vue from 'vue'
import VueRouter from 'vue-router';
import joyLayout from "./views/joyCenter/layouts/joyLayout";
import patientSearch from "./components/patient/patientSearch";
import consultation from "./views/joyCenter/consultation/consultation";
import queue from "./views/joyCenter/consultation/queue";
import welcome from "./views/home/welcome";
import hospital_admission from "./views/medical/hospitalization/hospital_admission";
import cpn_admission from "./views/medical/obstetrics/cpn/cpn_admission";
import obstetrics_layout from "./views/medical/obstetrics/layouts/obstetrics_layout";
import cpn_followup from "./views/medical/obstetrics/cpn/cpn_followup";
import first_cpn_list from "./views/medical/obstetrics/cpn/first_cpn_list";
import pregnancy_test from "./views/medical/obstetrics/cpn/pregnancy_test";
import welcoming from "./components/welcoming";



Vue.use(VueRouter);

const routes = [
    /** welcome routes**/
    {
        path: "/",
        name: "welcome",
        component: welcome
    },
    /**
    |---------------------------
     joyCenter routes
     |--------------------------
     */
    {
        path: "/joyCenter",
        name: "joyHome",
        component: joyLayout,
        children: [
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
    // hospitalisation
    {
        path: "hospital_admission/home",
        name: "hospital_admission_home",
        component: hospital_admission
    },
    // obstetrics
    {
        path: '/obstetrics',
        name: 'obstetrics_home',
        component: obstetrics_layout,
        children: [
            {
                path: 'home',
                name: 'obstetrics_welcome',
                component: welcoming
            },
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
            }
        ]
    }
];

const router = new VueRouter({
    routes,
    mode: 'history'
})



export default router;
