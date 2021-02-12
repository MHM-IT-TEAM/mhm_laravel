import Vue from 'vue'
import VueRouter from 'vue-router';
import PatientForm from "./components/patient";

Vue.use(VueRouter);

const routes=[
    {
        path:"/joyCenter/patient",
        name:"patForm",
        component:PatientForm
    }
];

const router = new VueRouter({
    routes,
    mode: 'history'
})



export default router;
