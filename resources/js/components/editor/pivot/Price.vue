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
            itemid: null,
            description: null,
            title: null,
            price: null,
        };
    },
    mounted() {
        this.setContent();
    },
    created() {
        
    },
    methods: {
        remove() {
            this.$parent.$parent.removeBlock(this.block.id);
        },
        json() {
            return {
                id: this.block.id,
                type: 'pivot-price',
                content: {
                    itemid: this.itemid,
                    description: this.description,
                    title: this.title,
                    price: this.price, 
                }
            };
        },
        setContent() {
            if(this.block.content) {
                this.itemid = this.block.content.itemid
                this.description = this.block.content.description
                this.title = this.block.content.title
                this.price = this.block.content.price
            }
        },
        chooseImage() {
            window.bus.$emit('toggle-image-chooser', this.block.id);
        }
    }
}
</script>