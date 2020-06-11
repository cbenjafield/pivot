<template>
    <div class="my-2">
        <div class="flex items-center text-sm">
            <div class="column-drag-handle bg-gray-200 text-gray-400 px-3 py-2">
                <i class="far fa-hand-paper"></i>
            </div>
            <div class="flex-1 pl-4">
                
            </div>
        </div>
        
        <div class="w-full">
            <input type="text" class="pr-field w-full border border-gray-200 rounded shadow-sm text-sm px-3" v-model="heading">
            <div class="pr-holder flex items-center justify-center text-lg text-gray-400">
                <i class="far fa-tasks-alt mr-2"></i> Pass Rates
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
</template>
<style lang="scss">
.pr-field {
    height: 30px;
}
.pr-holder {
    height: 220px;
}
</style>
<script>
export default {
    props: [
        'block'
    ],
    data() {
        return {
            heading: 'Our pass rates'
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
            this.heading = this.block.heading;
        }
    }
}
</script>