<template>
    <div class="flex items-start">
        <div class="flex-1 mr-6">
            <div class="shadow rounded-md overflow-hidden">
                <form id="checkout-form" class="p-4 bg-white">
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                        <label for="email" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Your email address
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                <input id="email" type="email" required class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" v-model="email">
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                        <label for="phone" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Your phone number
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                <input id="phone" type="tel" required class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" v-model="phone">
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                        <label for="pupil_name" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Pupil's name
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                <input id="pupil_name" type="text" required class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" v-model="pupil_name">
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                        <label for="phone" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                            Is there anything we should know?
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                <textarea class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" v-model="notes" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="w-1/3">
            <div class="shadow-md rounded-md overflow-hidden">
                <div class="bg-white p-4">
                    <h3 class="text-xl font-bold mb-4">Summary</h3>
                    <div class="basket-summary">

                    </div>
                </div>
                <div class="bg-gray-200 p-4">
                    <button class="w-full block p-3 bg-black text-white font-bold text-center">
                        <i class="fab fa-paypal fa-fw mr-2"></i> Pay with PayPal
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            email: null,
            phone: null,
            notes: null,
            pupil_name: null,
        }
    }
}
</script>
