/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// let en = '';
// let ar = '';
// $.ajax({
//     type: 'get',
//     async: false,
//     url: '/show/translations',
//     success: (response) => {
//         ar = response.ar;
//         en = response.en;
//     }
// });

import BootstrapVue from 'bootstrap-vue'
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import FileUpload from 'v-file-upload';
import ToggleButton from 'vue-js-toggle-button';
import VueI18n from 'vue-i18n'

Vue.use(VueI18n);


Vue.use(ToggleButton);
Vue.use(FileUpload);
Vue.use(BootstrapVue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import BaseComponent from './components/Request/BaseComponent';


const i18n = new VueI18n({
    locale: 'en'
});

window.bus = new Vue();

const app = new Vue({
    el: '#app',
    components: {BaseComponent},
    i18n,
    data(){
        return {
            currentLocale: '',
            currentLanguageLabel: ''
        }
    },
    mounted(){
        let currentLocale = document.querySelector('html').lang;
        if(currentLocale == 'ar'){
            this.currentLanguageLabel = 'English';
            this.currentLocale = 'ar';
        }else{
            this.currentLanguageLabel = 'عربي';
            this.currentLocale = 'en';
        }
        this.$i18n.locale = currentLocale;
    },
    methods: {
        changeLocale() {
            if (this.currentLocale == 'en') {
                this.currentLocale = 'ar';
                this.currentLanguageLabel = 'English';
            } else {
                this.currentLocale = 'en';
                this.currentLanguageLabel = 'عربي';
            }
            this.$i18n.locale = this.currentLocale;
            axios.get('/change_locale');
        }
    }
});

window.packageDetails = {};


import 'vue-multiselect/dist/vue-multiselect.min.css'
