<template>
    <div>
        <div class="sm:flex sm:items-start flex-wrap space-y-5">
            <div class="flex-1 pt-6">
                <div v-if="hasItems">
                    <div class="border-b border-gray-200 py-4 grid grid-cols-4 gap-4" v-for="item in basket" :key="item.itemId">
                        <div class="col-span-2">
                            <span class="block font-medium text-gray-900 text-xl">{{ item.name }}</span>
                        </div>
                        <div class="flex items-center">
                            <button class="text-gray-800 bg-gray-200 text-base rounded-l p-1" @click.prevent="updateQuantity(item.itemId, -1)"><i class="far fa-minus fa-fw"></i></button>
                            <span class="text-gray-800 text-base bg-gray-200 mx-1 p-1 block w-12 text-center font-bold">{{ item.quantity }}</span>
                            <button class="text-gray-800 bg-gray-200 text-base rounded-r p-1" @click.prevent="updateQuantity(item.itemId, 1)"><i class="far fa-plus fa-fw"></i></button>
                        </div>
                        <div class="text-xl font-bold text-right">
                            £{{ item.price * item.quantity | price }}
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 flex items-center justify-center p-4 rounded-md text-lg text-gray-500" v-else>
                    <div class="w-full text-center">
                        <p class="mb-3">There are no items in your basket.</p>
                        <a href="/prices" class="text-blue-600 focus:text-blue-700 transition duration-150 ease-in-out text-base">Visit our prices <i class="far fa-long-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="sm:w-1/3 sm:ml-10">
                <div class="rounded-md shadow overflow-hidden">
                    <div class="bg-white p-3 space-y-3">
                        <div class="grid grid-cols-3 gap-3 border-b border-gray-200 pb-3">
                            <div class="col-span-2 flex items-center text-sm">
                                Sub Total
                            </div>
                            <div class="font-bold text-base text-right">
                                £{{ basketSubtotal | price }}
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-3 border-b border-gray-200 pb-3">
                            <div class="col-span-2 flex items-center text-sm">
                                <div class="w-full">
                                    <span class="block">Management & Protection</span>
                                    <button class="text-xs appearance-none text-blue-500 focus:outline-none focus:text-blue-600 transition duration-150 ease-in-out" @click.prevent="managementProtection = true">What's this?</button>
                                </div>
                            </div>
                            <div class="font-bold text-base text-right">
                                £{{ basketFee | price }}
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="col-span-2 flex items-center text-lg font-medium">
                                Total
                            </div>
                            <div class="font-bold text-xl text-right">
                                £{{ basketTotal | price }}
                            </div>
                        </div>
                    </div>
                    <div class="p-3">
                        <a href="/checkout" class="bg-gray-900 block px-6 py-3 text-lg text-white font-medium text-center">
                            Checkout
                        </a>
                    </div>
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
export default {
    props: [
        'contents',
        'subtotal',
        'total',
        'fee',
    ],
    filters: {
        price(value) {
            return parseFloat(value).toFixed(2).replace('.00', '')
        }
    },
    data() {
        return {
            basket: this.contents || {},
            managementProtection: false,
            basketTotal: this.total,
            basketSubtotal: this.subtotal,
            basketFee: this.fee
        }
    },
    computed: {
        hasItems() {
            if(typeof this.basket == 'Array' && this.basket.length) return false;

            if(Object.keys(this.basket).length) return true

            return false
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
        updateQuantity(itemId, modifier) {
            if(typeof this.basket[itemId] == 'undefined') return

            this.basket[itemId].quantity += modifier

            axios.put(`/basket/${itemId}`, {
                quantity: this.basket[itemId].quantity,
            }).then(response => {
                this.basketTotal = response.data.total
                this.basketFee = response.data.fee
                this.basketSubtotal = response.data.subtotal

                if(this.basket[itemId].quantity == 0) {
                    delete this.basket[itemId]
                }
            })
        }
    }
}
</script>