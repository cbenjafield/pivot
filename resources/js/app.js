/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import 'medium-editor/dist/css/medium-editor.css';
import 'medium-editor/dist/css/themes/flat.css';

window.Vue = require('vue');

window.bus = new Vue;

Vue.component('editor', require('./components/Editor.vue').default);
Vue.component('editor-add-row', require('./components/editor/row.vue').default);
Vue.component('edit-article-form', require('./views/articles/Edit.vue').default);

var fireBusEvent = (event, payload) => {
    window.bus.$emit(event, payload);
};

const app = new Vue({
    el: '#app',
    data: {
        isUserOpen: false,
        isNavOpen: false,
        isArticleSaveOpen: false,
        articleErrors: null,
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
        },
        busEvent(event, payload) {
            return fireBusEvent(event, payload);
        },
        slugify(value, selector) {
            this.$nextTick(() => {
                var input = document.querySelector(selector);

                value = value.toString().toLowerCase()
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                    .replace(/^-+/, '')             // Trim - from start of text
                    .replace(/-+$/, '');            // Trim - from end of text
                
                if(!input.value) input.value = value;
            });
        },
        saveDraft() {
            document.querySelector('#status').value = 'draft';
            this.createArticle();
        },
        savePublish() {
            document.querySelector('#status').value = 'publish';
            this.createArticle();
        },
        createArticle() {
            const form = document.querySelector('#createArticleForm');
            var formData = new FormData(form);
            axios.post(form.getAttribute('action'), formData).then(response => {
                if(response.status == 201) {
                    window.location.href = response.data.redirect_url;
                }
            }).catch(error => {
                if(error.response) {
                    if(error.response.data.errors) {
                        this.articleErrors = response.data.errors
                    } else {
                        // Make this prettier.
                        alert('Failed to create the article.');
                    }
                }
            });
        }
    }
});
