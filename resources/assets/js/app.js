
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('loginform', require('./components/auth/LoginForm.vue'));
Vue.component('registerform', require('./components/auth/RegisterForm.vue'));
Vue.component('TodolistViewer', require('./components/TodolistViewer.vue'));
Vue.component('TasksViewer', require('./components/TasksViewer.vue'));

const app = new Vue({
    el: '#app',
});
