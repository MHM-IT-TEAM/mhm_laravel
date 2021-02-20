import Vue from 'vue'
import VueRouter from 'vue-router';
import joyLayout from "./views/joyCenter/layouts/joyLayout";
import patientCreate from "./components/patient/patientCreate";
import patientSearch from "./components/patient/patientSearch";


Vue.use(VueRouter);

const routes=[
/**
|---------------------------
 joyCenter routes
 |--------------------------
 */
    {
        path:"/joyCenter/home",
        component:joyLayout,
        children:[
            //patient
            {
                path:'patients/create',
                name:"patients.create",
                component:patientCreate
            },
            {
                path:'patients/search',
                name:"patients.search",
                component:patientSearch
            }
        ]
    }
];

const router = new VueRouter({
    routes,
    mode: 'history'
})



export default router;
