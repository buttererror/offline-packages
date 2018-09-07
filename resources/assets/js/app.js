
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import BootstrapVue from 'bootstrap-vue'
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import Vuetify from 'vuetify';
import '@fortawesome/fontawesome-free/css/all.css'
import colors from 'vuetify/es5/util/colors'
import FileUpload from 'v-file-upload'
// import Datepicker from 'vuejs-datepicker';

Vue.use(FileUpload)
// Vue.use(Datepicker)

Vue.use(Vuetify, {
    rtl: true,
    iconfont: 'fa',
    theme: {
        primary: colors.red.darken1, // #E53935
        secondary: colors.red.lighten4, // #FFCDD2
        accent: colors.indigo.base // #3F51B5
    }
});
Vue.use(BootstrapVue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import BaseComponent from './components/Request/BaseComponent';

window.bus = new Vue();
export const detailBus = new Vue();

const app = new Vue({
    el: '#app',
    components: {BaseComponent}
});



import 'v-autocomplete/dist/v-autocomplete.css';
import 'vuetify/dist/vuetify.css';
import 'vue-multiselect/dist/vue-multiselect.min.css'
