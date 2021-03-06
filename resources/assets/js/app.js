
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('./modules/confirm');

require('lightbox2');

window.tinymce = require('tinymce');

window.Dropzone = require('dropzone');

window.Vue = require('vue');

tinymce.init({
    selector:'.tinymce',
    themes: "modern",
    plugins: ["link","code","image","media"]
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('checkout', require('./components/Checkout.vue'));

// const app = new Vue({
//     el: '#app'
// });
