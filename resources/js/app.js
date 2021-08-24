/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

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




window.Vue = require('vue').default;

import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect);
Vue.component('Loading', Loading)
Vue.component('calendar', Calendar)
Vue.component('date-picker', DatePicker)
Vue.component('yes-or-no', YesOrNo)
Vue.use(VueHtmlToPaper)


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
