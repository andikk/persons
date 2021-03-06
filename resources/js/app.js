/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

window.Vue = require('vue');
// компонент для отображения даты в определенном формате
import VueFilterDateFormat from 'vue-filter-date-format';
window.Vue.use(VueFilterDateFormat);


//компонент для валидации форм
import { extend } from 'vee-validate';
import { required } from 'vee-validate/dist/rules';
import { regex } from 'vee-validate/dist/rules';

//правила валидации
extend('required', {
  ...required,
  message: 'Данное поле обязательно к заполнению'
});

extend('regex', {
  ...regex,
  message: 'Дата должна быть в формате ДД.ММ.ГГГГ'
});

import { ValidationProvider } from 'vee-validate';
//import { ValidationProvider } from 'vee-validate/dist/vee-validate.full';
Vue.component('ValidationProvider', ValidationProvider);


import App from "./components/App";



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    render: h => h(App)
});
