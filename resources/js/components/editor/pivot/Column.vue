<template>
    <div class="px-3 mb-3" :class="[
        `w-${width}`,
        classNames,
    ]">
        <div class="p-3 shadow bg-white">
            <div class="flex items-center text-sm">
                <div class="flex-1 py-2">
                    <button type="button" class="text-gray-500" @click.prevent="isOptionsOpen = true">
                        <i class="far fa-cog mr-1"></i> Options
                    </button>
                </div>
            </div>
            <div>
                <draggable v-model="blocks" group="columnBlocks" handle=".column-drag-handle">
                    <component v-for="block in blocks" :key="block.id" :is="block.type" :block="block" :ref="block.id"/>
                </draggable>
            </div>
            <div class="mt-2 pt-2 flex items-center">
                <div class="flex-1 flex items-center text-sm">
                    <button type="button" class="text-indigo-500 mr-4" @click.prevent="openAddElement">
                        <i class="far fa-plus mr-1"></i> Add
                    </button>
                </div>
                <div>
                    <button type="button" class="text-sm text-gray-500" @click.prevent="remove"><i class="far fa-times mr-1"></i> Remove</button>
                    <input type="text" v-model="width" class="border rounded border-gray-200 text-sm w-10">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import draggable from 'vuedraggable'

export default {
    props: [
        'column'
    ],
    components: {
        draggable,
    },
    data() {
        return {
            width: this.column.initialWidth,
            blocks: [],
            classNames: null
        };
    },
    mounted() {
        this.setContent();
    },
    created() {
        window.bus.$on('insert-element', (payload) => {
            if(payload.ref == this.column.id) {
                this.insertBlock(payload.type);
            }
        });
    },
    methods: {
        openAddElement() {
            window.bus.$emit('open-insert-element', this.column.id);
        },
        insertBlock(type) {
            this[type]();
        },
        removeBlock(id) {
            this.blocks.splice(this.blocks.findIndex(block => block.id === id), 1);
        },
        remove() {
            this.$parent.removeColumn(this.column.id);
        },
        text() {
            this.blocks.push({
                id: `text-${window.randomString(8)}`,
                type: 'pivot-text',
                content: null
            });
        },
        image() {
            this.blocks.push({
                id: `image-${window.randomString(8)}`,
                type: 'pivot-image',
                src: null
            });
        },
        passrates() {
            this.blocks.push({
                id: `passrates-${window.randomString(8)}`,
                type: 'pivot-passrates',
                heading: null
            });
        },
        address() {
            this.blocks.push({
                id: `address-${window.randomString(8)}`,
                type: 'pivot-address',
                heading: null
            });
        },
        markdown() {
            this.blocks.push({
                id: `md-${window.randomString(8)}`,
                type: 'pivot-md',
                content: null
            });
        },
        row() {
            this.blocks.push({
                id: `row-${window.randomString(8)}`,
                type: 'pivot-row',
                content: null
            });
        },
        json() {
            var object = {
                id: this.column.id,
                type: 'pivot-column',
                blocks: [],
                width: this.width
            };

            this.blocks.forEach((block) => {
                let ref = this.$refs[block.id][0];
                object.blocks.push(ref.json());
            });

            return object;
        },
        setContent() {
            let content = this.column.content;
            if(!content) return false;

            content.forEach(block => {
                let newBlock = {
                    id: block.id,
                    type: block.type,
                    content: null
                };

                if(newBlock.type == 'pivot-row') {
                    newBlock.content = block.blocks;
                }
                if(newBlock.type == 'pivot-text' || newBlock.type == 'pivot-md') {
                    newBlock.content = block.content;
                }
                if(newBlock.type == 'pivot-passrates') {
                    newBlock.heading = block.heading;
                }
                if(newBlock.type == 'pivot-image') {
                    newBlock.content = block.content;
                }

                this.blocks.push(newBlock);
            });
        }
    }
}
</script>