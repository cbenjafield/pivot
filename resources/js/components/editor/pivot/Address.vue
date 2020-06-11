<template>
    <div class="my-2">
        <div class="flex items-center text-sm">
            <div class="column-drag-handle bg-gray-200 text-gray-400 px-3 py-2">
                <i class="far fa-hand-paper"></i>
            </div>
            <div class="flex-1 pl-4">
                
            </div>
        </div>
        
        <div class="address-field border border-gray-200 flex items-center justify-center text-lg text-gray-400">
            <i class="far fa-map-marker-alt mr-2"></i> Website Address
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
</template>
<style lang="scss">
.address-field {
    height: 160px;
}
</style>
<script>
export default {
    props: [
        'block'
    ],
    data() {
        return {
            heading: null
        };
    },
    mounted() {
        this.setContent();
    },
    methods: {
        remove() {
            this.$parent.$parent.removeBlock(this.block.id);
        },
        json() {
            return {
                id: this.block.id,
                type: this.block.type,
                heading: this.heading
            };
        },
        setContent() {
            if(this.block.heading) {
                this.heading = this.block.heading;
            }
        }
    }
}
</script>