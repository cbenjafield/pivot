<template>
    <div class="shadow-sm rounded-md sm:overflow-hidden" :class="[activeClass]" @click.prevent="isActive =! isActive">
        <div class="bg-white p-2" :class="[
            (isActive ? 'w-1/2' : '')
        ]">
            <div class="bg-gray-300 flex items-center justify-center overflow-hidden" :class="[
                (isActive ? '' : 'h-40')
            ]">
                <img :src="file.website_url" class="object-cover min-h-full min-w-full block" v-if="isImage">
            </div>
        </div>
        <div class="bg-white p-3 flex-1 pl-6" v-if="isActive">
            <div>
                <h4 class="font-medium text-gray-600 text-xs mb-2">Filename</h4>
                <p class="text-gray-900">{{ file.name }}</p>
            </div>
            <div class="mt-4">
                <h4 class="font-medium text-gray-600 text-xs mb-2">Original Filename</h4>
                <p class="text-gray-900">{{ file.original_name }}</p>
            </div>
            <div class="mt-4">
                <h4 class="font-medium text-gray-600 text-xs mb-2">URL</h4>
                <a :href="file.url" target="_blank" class="block text-indigo-600 truncate pr-10">{{ file.url }}</a>
            </div>
            <div class="mt-4">
                <span class="inline-flex rounded-md shadow-sm">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150" @click.prevent="chooseImage(file.website_url)">
                        Choose Image
                    </button>
                </span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: [
        'file'
    ],
    data() {
        return {
            isActive: false
        };
    },
    computed: {
        isImage() {
            return /\.(jpe?g|png|gif)$/i.test(this.file.name);
        },
        activeClass() {
            if(this.isActive) {
                return [
                    'col-span-4',
                    'flex',
                ].join(' ');
            }
            return null;
        }
    },
    methods: {
        chooseImage(src) {
            window.bus.$emit('choose-image', {
                src: src,
                blockId: this.$parent.blockId || null
            });
        }
    }
}
</script>