require('./bootstrap');

window.Vue = require('vue');

window.bus = new Vue;

const app = new Vue({
    el: '#site',
    methods: {
        toggleMenu() {
            document.querySelector('body').classList.toggle('menu-open');
        }
    }
});