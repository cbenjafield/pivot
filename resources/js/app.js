/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#app',
    data: {
        isUserOpen: false,
        isNavOpen: false
    },
    methods: {
        submitForm(selector) {
            this.$nextTick(() => {
                this.$nextTick(() => {
                    console.log(selector);
                    console.log(document.querySelector(selector));
                });
            });
        },
        closeAlert(target) {
            this.$nextTick(() => {
                target.closest('.alert').remove();
            });
        }
    }
});
