<template>
    <div class="flex items-start">
        <div class="flex-1 mr-6">
            <div class="shadow rounded-md overflow-hidden">
                <div class="p-4 pb-0">
                    <h3 class="text-xl font-bold mb-4">Payment Details</h3>
                </div>
                <div class="pb-4 px-4" v-if="paypal">
                    <div class="rounded p-4 flex items-center space-x-4 border-l-4 text-gray-900 shadow-sm" :class="paypal.class">
                        <i class="far text-2xl" :class="paypal.icon"></i>
                        <div class="flex-1">
                            {{ paypal.message }}
                        </div>
                    </div>
                </div>
                <form id="checkout-form" class="p-4 pt-0 bg-white" ref="form">
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                        <label for="email" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Your email address
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                <input id="email" name="email" type="email" required data-message="Please enter your email." class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" v-model="email">
                            </div>
                            <form-error :error="error('email')" />
                        </div>
                    </div>
                    <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                        <label for="phone" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Your phone number
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                <input id="phone" name="phone" type="tel" required data-message="Please enter your phone number." class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" v-model="phone">
                            </div>
                            <form-error :error="error('phone')" />
                        </div>
                    </div>
                    <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                        <label for="pupil_name" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Pupil's name
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                <input id="pupil_name" name="pupil_name" type="text" required data-message="Please enter the pupil's name." class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" v-model="pupil_name">
                            </div>
                            <form-error :error="error('pupil_name')" />
                        </div>
                    </div>
                    <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                        <label for="pupil_postcode" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Pupil's postcode
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                <input id="pupil_postcode" name="pupil_postcode" type="text" required data-message="Please enter the pupil's postcode." class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" v-model="pupil_postcode">
                            </div>
                            <form-error :error="error('pupil_postcode')" />
                        </div>
                    </div>
                    <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                        <label for="phone" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Is there anything we should know?
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                <textarea name="notes" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" v-model="notes" rows="7"></textarea>
                            </div>
                            <form-error :error="error('notes')" />
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="w-1/3">
            <div class="shadow-md rounded-md overflow-hidden">
                <div class="bg-white p-4">
                    <h3 class="text-xl font-bold mb-4">Summary</h3>
                    <div class="basket-summary space-y-2">
                        <basket-summary-item :item="item" v-for="item in basketItems" :key="item.id" />
                    </div>
                </div>
                <div class="p-4 space-y-2">
                    <div class="grid grid-cols-2 text-right px-3">
                        <div class="text-xs">
                            Sub Total
                        </div>
                        <div class="text-sm font-bold">
                            £{{ subtotal | price }}
                        </div>
                    </div>
                    <div class="grid grid-cols-2 text-right px-3">
                        <div class="text-xs">
                            <span class="block">Management & Protection</span>
                            <button type="button" class="appearance-none text-blue-500 text-xs inline-block focus:text-blue-600 transition duration-150 ease-in-out mt-1 focus:outline-none" @click.prevent="managementProtection = true">
                                What's this?
                            </button>
                        </div>
                        <div class="text-sm font-bold">
                            £{{ fee | price }}
                        </div>
                    </div>
                    <div class="grid grid-cols-2 text-right px-3 border-t border-gray-200 pt-3">
                        <div class="text-lg font-medium">
                            Total
                        </div>
                        <div class="text-xl font-bold">
                            £{{ total | price }}
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-white">
                    <div class="bg-gray-100 rounded-md p-3 text-sm">
                        <p>By clicking the "Pay with PayPal" button below, you are agreeing to our <a href="/terms" class="text-blue-500 focus:text-blue-700 transition duration-150 ease-in-out" target="_blank">Terms &amp; Conditions</a>.</p>
                    </div>
                </div>
                <div class="bg-gray-200 p-4">
                    <button class="w-full block p-3 bg-black text-white font-bold text-center focus:outline-none focus:bg-gray-800" type="submit" @click.prevent="pay">
                        <i class="fab fa-paypal fa-fw mr-2"></i> Pay with PayPal
                    </button>
                </div>
            </div>
        </div>
        <transition
            enter-active-class="transition-all duration-300 ease-out"
            enter-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-all duration-300 ease-in"
            leave-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div class="fixed inset-0 flex items-center justify-center z-50 overflow-y-auto p-4 sm:p-8" v-if="managementProtection">
                <div class="fixed inset-0 bg-black opacity-50"></div>
                <div class="w-full max-w-md shadow-md overflow-hidden my-auto relative rounded-md">
                    <div class="bg-white p-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900">What is Management &amp; Protection?</h3>
                            </div>
                            <button class="w-8 h-8 rounded-full flex items-center justify-center focus:outline-none appearance-none focus:bg-gray-200 transition duration-150 ease-in-out text-gray-500 text-xl" type="button" @click="managementProtection = false">
                                <i class="far fa-times"></i>
                            </button>
                        </div>
                        <div class="mt-4 text-sm space-y-3 text-gray-600">
                            <p>There is a small 4.5% charge for booking online or paying over the phone. This is a Management and Protection fee which secures your payment.</p>
                            <p>If you would like to avoid this charge, you are very welcome to pay your allocated driving instructor on the day of your first lesson. Like all driving schools in the UK, the money you pay the instructor will be between you and them, and we cannot protect your money against unforeseen circumstances the same as if you pay us directly.</p>
                            <p>If you choose to pay on the day, your instructor will issue you a receipt.</p>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
<script>
import BasketSummaryItem from './BasketItem'
import FormError from '../ui/FormError'

export default {
    components: {
        BasketSummaryItem,
        FormError,
    },
    props: [
        'contents',
        'subtotal',
        'total',
        'fee',
        'paypalStatus'
    ],
    filters: {
        price(value) {
            return parseFloat(value).toFixed(2).replace('.00', '')
        }
    },
    data() {
        return {
            email: null,
            phone: null,
            notes: null,
            pupil_name: null,
            pupil_postcode: null,
            basketItems: this.contents || [],
            managementProtection: false,
            errors: {},
            generalError: null,
            paypalOptions: {
                error: {
                    icon: 'fa-times text-red-600',
                    class: 'bg-red-100 border-red-600',
                    message: 'A PayPal error occurred.'
                },
                cancel: {
                    icon: 'fa-exclamation-triangle text-orange-500',
                    class: 'bg-orange-100 border-orange-500',
                    message: 'This PayPal transaction has been cancelled.'
                }
            }
        }
    },
    computed: {
        hasErrors() {
            if(! this.errors || ! Object.keys(this.errors).length) {
                return false
            }

            return true
        },
        paypal() {
            if(! this.paypalStatus || typeof this.paypalOptions[this.paypalStatus] == 'undefined') {
                return false
            }

            return this.paypalOptions[this.paypalStatus]
        }
    },
    watch: {
        managementProtection(value, old) {
            if(value) {
                document.querySelector('body').classList.add('overflow-y-hidden')
            } else {
                document.querySelector('body').classList.remove('overflow-y-hidden')
            }
        }
    },
    methods: {
        error(field) {
            if(! this.hasErrors || typeof this.errors[field] == 'undefined' || ! this.errors[field].length) {
                return false
            }

            return this.errors[field][0]
        },
        validate() {
            this.errors = {}
            this.generalError = null

            this.$refs.form.querySelectorAll('[required]').forEach(element => {
                let field = element.getAttribute('name'),
                    message = element.getAttribute('data-message') || 'This field is required.'

                if(! this.$data[field]) {
                    this.errors[field] = [message]
                }
            })

            return ! this.hasErrors
        },
        pay() {
            if(! this.validate()) {
                return
            }

            let { email, phone, pupil_name, notes, pupil_postcode } = this.$data

            axios.post('/checkout/pay', {
                email, phone, pupil_name, notes, pupil_postcode
            }).then(response => {
                window.location.href=response.data.redirect_url
            }).catch(error => {
                if(error.response) {
                    if(error.response.status == 422) {
                        this.errors = error.response.data.errors
                    }
                }

                this.generalError = 'An error occurred.'
            })
        }
    }
}
</script>
