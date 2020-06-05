<template>
    <div class="editor absolute bottom-0 border-t border-gray-200 w-full p-6 pt-16 overflow-y-auto">
        <div class="h-10 flex items-center justify-end absolute top-0 left-0 right-0 px-4 pt-4">
            <div class="relative inline-block text-left">
                <div>
                    <span class="rounded-md shadow-sm">
                        <button type="button"
                            class="inline-flex items-center justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150"
                            @click.prevent="isInsertOpen =! isInsertOpen"
                        >
                            <i class="far fa-plus mr-3"></i> Insert block
                            <svg class="-mr-1 ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </span>
                </div>

                <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-class="transform opacity-100 scale-100"
                    leave-to="transform opacity-0 scale-95"
                >
                    <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg z-front" v-if="isInsertOpen">
                        <div class="rounded-md bg-white shadow-xs">
                            <div class="py-1">
                                <a href="#"
                                    class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" @click.prevent="insertBlock('text')">Text</a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" @click.prevent="insertBlock('row')">Row with columns</a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" @click.prevent="insertBlock('hero')">Hero Section</a>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
        <div class="editor-content">
            <draggable v-model="blocks" group="rootBlocks" handle=".drag-handle">
                <component v-for="block in blocks" :key="block.id" :block="block" :is="block.type" class="mb-6" :ref="block.id"/>
            </draggable>
        </div>
    </div>
</template>
<style lang="scss">
.editor {
    top: 8rem;
}
</style>
<script>
import draggable from 'vuedraggable'

export default {
    props: [
        'value'
    ],
    components: {
        draggable,
    },
    data() {
        return {
            isInsertOpen: false,
            blocks: [],
        }
    },
    computed: {
        nextIndex() {
            return this.blocks.length + 1;
        }
    },
    mounted() {
        this.setContent();
    },
    methods: {
        insertBlock(type) {
            this.isInsertOpen = false;
            this[type]();
        },
        removeBlock(id) {
            this.blocks.splice(this.blocks.findIndex(block => block.id === id), 1);
        },
        text() {
            this.blocks.push({
                id: `text-${window.randomString(8)}`,
                type: 'pivot-text',
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
        hero() {
            this.blocks.push({
                id: `hero-${window.randomString(8)}`,
                type: 'pivot-hero',
                content: null
            })
        },
        getContent() {
            var content = [];

            this.blocks.forEach((block) => {
                let ref = this.$refs[block.id][0];
                content.push(ref.json());
            });

            return content;
        },
        setContent() {
            if(!this.value) return false;

            var content = JSON.parse(this.value);

            content.forEach(block => {
                let newBlock = {
                    id: block.id,
                    type: block.type,
                    content: null
                };

                if(newBlock.type == 'pivot-row') {
                    newBlock.content = block.blocks;
                    newBlock.sectionClassNames = block.sectionClassNames;
                    newBlock.classNames = block.classNames;
                }
                if(newBlock.type == 'pivot-text') {
                    newBlock.content = block.content;
                }
                if(newBlock.type == 'pivot-hero') {
                    newBlock.content = {
                        headingText: block.headingText,
                        bullets: block.bullets,
                        backgroundImage: block.backgroundImage,
                        classNames: block.classNames
                    };
                }

                this.blocks.push(newBlock);
            });
        }
    }
}
</script>