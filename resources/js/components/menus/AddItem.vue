<template>
    <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
        <div class="px-4 py-5 bg-white sm:p-6">
            <h3 class="font-medium text-gray-900 mb-6 text-xl pb-4 border-b border-gray-200">Add an item to the menu</h3>
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                <label for="item-title" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Title
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-xs rounded-md shadow-sm">
                        <input type="text" id="item-title" name="title" v-model="title" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="E.g. About Us" />
                    </div>
                    <p class="mt-2 text-sm text-gray-500">This is the text that will show in the link.</p>
                </div>
            </div>
            <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                <label for="destination" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Destination
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-xs rounded-md shadow-sm">
                        <input type="text" id="destination" name="destination" v-model="destination" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="E.g. /about-us" />
                    </div>
                    <p class="mt-2 text-sm text-gray-500">This is where the link will point to. Is absolute.</p>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <span class="inline-flex rounded-md shadow-sm">
                <button type="button" class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out" @click.prevent="addItem">
                    <i class="far fa-plus mr-2"></i> Add Item
                </button>
            </span>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            title: null,
            destination: null
        }
    },
    methods: {
        addItem() {
            this.$parent.addItem(this.title, this.destination);
            this.title = null;
            this.destination = null;
        }
    }
}
</script>