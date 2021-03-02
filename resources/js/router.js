import Vue from 'vue'
import VueRouter from 'vue-router';
import joyLayout from "./views/joyCenter/layouts/joyLayout";
import patientSearch from "./components/patient/patientSearch";
import consultation from "./views/joyCenter/consultation/index";
import queue from "./views/joyCenter/consultation/queue";



Vue.use(VueRouter);

const routes = [
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
            //consultation
            {
                path:'queueList',
                name:"consultation.list",
                component:queue
            }
        ]
    }
];

const router = new VueRouter({
    routes,
    mode: 'history'
})



export default router;
