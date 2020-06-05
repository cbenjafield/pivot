<template>
    <div>
        <div class="my-2">
            <div class="flex items-center text-sm">
                <div class="column-drag-handle bg-gray-200 text-gray-400 px-3 py-2">
                    <i class="far fa-hand-paper"></i>
                </div>
                <div class="flex-1 pl-4">
                    <button type="button" class="text-gray-500" @click.prevent="isOptionsOpen = true">
                        <i class="far fa-cog mr-1"></i> Options
                    </button>
                </div>
            </div>
            <div class="border border-gray-200 p-2">
                <div class="p-6 rounded-md bg-gray-100 text-center" @click.prevent="chooseImage" v-if="!src">
                    <i class="far fa-image"></i> Choose Image
                </div>
                <div v-else @click.prevent="chooseImage">
                    <img :src="src" class="h-auto w-full">
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                <div class="flex-1 mr-6">

                </div>
                <div>
                    <button type="button" class="text-gray-500" @click.prevent="remove">
                        <i class="far fa-times mr-1"></i> Remove
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: [
        'block'
    ],
    data() {
        return {
            src: null,
            alt: null
        };
    },
    mounted() {
        this.setContent();
    },
    created() {
        window.bus.$on('choose-image', (payload) => {
            if(payload.blockId == this.block.id) {
                this.src = payload.src;
            }
        });
    },
    methods: {
        remove() {
            this.$parent.$parent.removeBlock(this.block.id);
        },
        json() {
            return {
                id: this.block.id,
                type: 'pivot-image',
                content: {
                    src: this.src,
                    alt: this.alt
                }
            };
        },
        setContent() {
            if(this.block.content) {
                this.src = this.block.content.src;
                this.alt = this.block.content.alt;
            }
        },
        chooseImage() {
            window.bus.$emit('toggle-image-chooser', this.block.id);
        }
    }
}
</script>