
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


import BootstrapVue from 'bootstrap-vue'
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import FileUpload from 'v-file-upload';
import ToggleButton from 'vue-js-toggle-button';
import flatpickr from "flatpickr";
import flatPickr from  'vue-flatpickr-component';

Vue.use(flatPickr);



Vue.use(ToggleButton);
Vue.use(FileUpload);
Vue.use(BootstrapVue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import BaseComponent from './components/Request/BaseComponent';

window.bus = new Vue();

const app = new Vue({
    el: '#app',
    components: {BaseComponent}
});



window.packageDetails = {};


import 'vue-multiselect/dist/vue-multiselect.min.css'
