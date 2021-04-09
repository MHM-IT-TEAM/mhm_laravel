import Vue from 'vue'
import VueRouter from 'vue-router';
import joyLayout from "./views/joyCenter/layouts/joyLayout";
import patientSearch from "./components/patient/patientSearch";
import consultation from "./views/joyCenter/consultation/consultation";
import queue from "./views/joyCenter/consultation/queue";
import welcome from "./views/home/welcome";
import hospital_admission from "./components/hospital_admission/hospital_admission";
import cpn_admission from "./components/obstetrics/cpn/cpn_admission";



Vue.use(VueRouter);

const routes = [
    /** welcome routes**/
    {
        path:"/",
        name:"welcome",
        component: welcome
    },
    /**
    |---------------------------
     joyCenter routes
     |--------------------------
     */
    {
        path: "/joyCenter/home",
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
                path:'consultation',
                name:"consultation.new",
                component:consultation
            },
            //queue list
            {
                path:'queueList',
                name:"consultation.list",
                component:queue
            },
            // hospital admission
            {
                path:'hospital_admission',
                name:"hospital_admission.new",
                component:hospital_admission
            },
            // CPN
            {
                path:'cpn_admission',
                name:'cpn_admission',
                component: cpn_admission
            }

        ]
    }
];

const router = new VueRouter({
    routes,
    mode: 'history'
})



export default router;
