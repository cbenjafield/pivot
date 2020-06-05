<template>
    <div class="fixed inset-0 z-front flex items-center justify-center overflow-y-auto p-6" v-if="isOpen">
        <div class="bg-white opacity-75 fixed inset-0" @click.prevent="isOpen =! isOpen"></div>

        <div class="bg-gray-100 rounded-md shadow-lg overflow-hidden max-w-7xl w-full relative py-4 my-10">
            <media-library :website="website" :show-chooser="true" :block-id="blockId" />
        </div>
    </div>
</template>
<script>
import Media from '../../views/media/Index'

export default {
    components: {
        'media-library': Media,
    },
    data() {
        return {
            isOpen: false,
            blockId: null
        };
    },
    created() {
        window.bus.$on('toggle-image-chooser', (payload) => {
            this.isOpen =! this.isOpen;
            this.blockId = payload;
        });

        window.bus.$on('choose-image', () => {
            this.isOpen = false;
        });
    },
    computed: {
        website() {
            return window.siteId;
        }
    }
}
</script>