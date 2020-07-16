<template>
    <div class="my-2">
        <div class="flex items-center text-sm">
            <div class="column-drag-handle bg-gray-200 text-gray-400 px-3 py-2">
                <i class="far fa-hand-paper"></i>
            </div>
            <div class="flex-1 pl-4">
                
            </div>
        </div>
        
        <textarea v-model="content" class="md-field w-full border border-gray-200 rounded-none p-3 text-sm" rows="10"></textarea>

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
.md-field {
    height: 250px;
}
</style>
<script>
export default {
    props: [
        'block'
    ],
    data() {
        return {
            content: 'Enter markdown here...'
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
                content: this.content
            };
        },
        change() {
            this.content = this.getMarkdown();
            this.$forceUpdate();
        },
        setContent() {
            if(this.block.content) {
                this.content = this.block.content;
            }
        }
    }
}
</script>