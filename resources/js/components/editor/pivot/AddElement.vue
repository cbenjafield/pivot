<template>
    <div class="fixed inset-0 z-front flex items-center justify-center p-6" v-if="isOpen">
        <div class="fixed inset-0 bg-black opacity-75"></div>
        <div class="w-full max-w-3xl bg-white rounded-md shadow-lg p-4 relative">
            <div class="pb-4 flex items-center">
                <div class="flex-1 text-lg font-medium text-gray-700 mr-4">
                    Add Element
                </div>
                <button class="text-xl text-gray-500" @click.prevent="close">
                    <i class="far fa-times"></i>
                </button>
            </div>
            <div class="grid grid-cols-4 gap-4 text-center">
                <div class="p-4 cursor-pointer bg-white rounded-md shadow hover:bg-indigo-50 transition-colors duration-200" @click.prevent="add('text')">
                    <i class="far fa-text text-3xl text-gray-500 block mb-4"></i>
                    <span class="block font-medium">Text</span>
                </div>
                <div class="p-4 cursor-pointer bg-white rounded-md shadow hover:bg-indigo-50 transition-colors duration-200" @click.prevent="add('image')">
                    <i class="far fa-image text-3xl text-gray-500 block mb-4"></i>
                    <span class="block font-medium">Image</span>
                </div>
                <div class="p-4 cursor-pointer bg-white rounded-md shadow hover:bg-indigo-50 transition-colors duration-200" @click.prevent="add('markdown')">
                    <i class="fab fa-markdown text-3xl text-gray-500 block mb-4"></i>
                    <span class="block font-medium">Raw Markdown</span>
                </div>
                <div class="p-4 cursor-pointer bg-white rounded-md shadow hover:bg-indigo-50 transition-colors duration-200" @click.prevent="add('contact')">
                    <i class="far fa-envelope-open-text text-3xl text-gray-500 block mb-4"></i>
                    <span class="block font-medium">Contact Form</span>
                </div>
                <div class="p-4 cursor-pointer bg-white rounded-md shadow hover:bg-indigo-50 transition-colors duration-200" @click.prevent="add('passrates')">
                    <i class="far fa-tasks-alt text-3xl text-gray-500 block mb-4"></i>
                    <span class="block font-medium">Pass Rates</span>
                </div>
                <div class="p-4 cursor-pointer bg-white rounded-md shadow hover:bg-indigo-50 transition-colors duration-200" @click.prevent="add('address')">
                    <i class="far fa-map-marker-alt text-3xl text-gray-500 block mb-4"></i>
                    <span class="block font-medium">Address Block</span>
                </div>
                <div class="p-4 cursor-pointer bg-white rounded-md shadow hover:bg-indigo-50 transition-colors duration-200" @click.prevent="add('price')">
                    <i class="far fa-pound-sign text-3xl text-gray-500 block mb-4"></i>
                    <span class="block font-medium">Price</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            ref: null,
            isOpen: false
        }
    },
    created() {
        window.bus.$on('open-insert-element', (payload) => {
            this.open(payload);
        });
    },
    methods: {
        open(ref) {
            this.ref = ref;
            this.isOpen = true;
        },
        add(type) {
            window.bus.$emit('insert-element', {
                type: type,
                ref: this.ref
            });

            this.close();
        },
        close() {
            this.isOpen = false;
            this.ref = null;
        }
    }
}
</script>