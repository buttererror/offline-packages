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
import VueI18n from 'vue-i18n'
import VueRouter from 'vue-router';

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
import Steps from './components/Request/Steps';


const i18n = new VueI18n({
    locale: 'en'
});

const routes = [
    {path: '/step', component: Steps},
];


const router = new VueRouter({
    routes
});

window.bus = new Vue();

const app = new Vue({
    el: '#app',
    router,
    components: {BaseComponent},
    i18n,
    data() {
        return {
            currentLocale: '',
            currentLanguageLabel: '',
            user: {
                id: '',
                name: '',
                password: '',
                csrf_token: ''
            }
        }
    },
    mounted() {
        let currentLocale = document.querySelector('html').lang;
        if (currentLocale == 'ar') {
            this.currentLanguageLabel = 'English';
            this.currentLocale = 'ar';
        } else {
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
        },
        loginUser() {
            axios.post('/auth/login', {
                'email': this.user.email,
                'password': this.user.password
            }).then(response => {

                localStorage.setItem('token','Bearer '+ response.data.access_token)

                axios.defaults.headers.common['Authorization'] =  localStorage.getItem('token');
                let url = response.data.url;
                localStorage.setItem('user_id', response.data.user.id);
                window.location.href=url;


            });
        },
        logoutUser() {
            axios.post('/auth/logout').then(response => {
                localStorage.removeItem('token');
                localStorage.removeItem('user_id');

                window.location.href = response.data.url

            });
        }
    }
});


window.packageDetails = {};


import 'vue-multiselect/dist/vue-multiselect.min.css'
