const { default: Axios } = require('axios');

require('./bootstrap');

window.Vue = require('vue');

Vue.component(
    'basket-button',
    require('./components/ui/BasketButton.vue').default
);

Vue.component(
    'checkout-form',
    require('./components/checkout/Checkout.vue').default
);

window.bus = new Vue;

const app = new Vue({
    el: '#site',
    data: {
        contactFormErrors: [],
        success: {},
        error: {},
    },
    methods: {
        toggleMenu() {
            document.querySelector('body').classList.toggle('menu-open');
        },
        submitContactForm(event) {
            const form = event.target;
            const formData = new FormData(form);

            this.contactFormErrors = [];
            delete this.success[form.getAttribute('id')];
            delete this.error[form.getAttribute('id')];

            axios.post(event.target.getAttribute('action'), formData).then(response => {
                // Successful response...
                this.success[form.getAttribute('id')] = `Your message has been sent. We'll get back to you as soon as possible.`;
                this.$forceUpdate();
            }).catch(error => {
                // Unsuccessful response...
                if(error.response) {
                    if(error.response.data.errors) {
                        this.contactFormErrors = error.response.data.errors;
                    }
                    this.error[form.getAttribute('id')] = `An error occurred and your message could not be sent.`;
                    this.$forceUpdate();
                }
            });
        },
        contactFormError(field) {
            if(typeof this.contactFormErrors[field] != 'undefined' && this.contactFormErrors[field].length) {
                return this.contactFormErrors[field][0];
            }

            return null;
        },
        successMessage(formId) {
            console.log(formId);
            console.log(typeof this.success[formId]);
            if(typeof this.success[formId] != 'undefined' && this.success[formId]) {
                console.log(this.success[formId]);
                return this.success[formId];
            }
            return null;
        },
        errorMessage(formId) {
            if(typeof this.error[formId] != 'undefined' && this.error[formId]) {
                console.log(this.error[formId]);
                return this.error[formId];
            }
            return null;
        }
    }
});
