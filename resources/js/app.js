/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue";

require('./bootstrap');
import router from './router';
import store from './store/index';
import vuetify from "./plugins/vuetify";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import VueHtmlToPaper from 'vue-html-to-paper';
import Calendar from 'v-calendar/lib/components/calendar.umd'
import DatePicker from 'v-calendar/lib/components/date-picker.umd'
import YesOrNo from './components/yes_or_no.vue'
import moment from 'moment'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import Multiselect from 'vue-multiselect'
import Pagination from 'vue-pagination-2';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueBarcodeScanner from 'vue-barcode-scanner'




window.Vue = require('vue').default;
library.add(fas)


Vue.component('multiselect', Multiselect);
Vue.component('Loading', Loading)
Vue.component('calendar', Calendar)
Vue.component('date-picker', DatePicker)
Vue.component('yes-or-no', YesOrNo)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.component('pagination', Pagination);
Vue.use(VueHtmlToPaper)
Vue.use(VueSweetalert2)
Vue.use(VueBarcodeScanner)
Vue.prototype.moment = moment
//api routes shortening
Vue.prototype.CONSULTATION ='/api/v1/patient_system/out_patient/consultation'


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('datepicker',Datepicker);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    router,
    store,
    vuetify,
    el: '#app',
});
