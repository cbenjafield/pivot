<template>
<div class="fixed bottom-0 inset-x-0 px-4 pb-6 sm:inset-0 sm:p-0 sm:flex sm:items-center sm:justify-center z-50" v-show="isOpen">
    <transition
        enter-active-class="ease-out duration-300"
        enter-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200"
        leave-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div class="fixed inset-0 transition-opacity" v-if="isOpen">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
    </transition>
    <transition
        enter-active-class="ease-out duration-300"
        enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
        leave-active-class="ease-in duration-200"
        leave-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <div class="relative bg-white rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-4xl sm:w-full sm:p-6"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                <button type="button"
                    class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150"
                    aria-label="Close" @click.prevent="close">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div>
                <div>
                    <label for="colText" class="block text-sm font-medium leading-5 text-gray-700">Enter number of columns in fractions</label>
                    <p class="text-gray-500 text-sm">E.g. "2/3,1/3" will add 2 columns.</p>
                    <div class="mt-2 relative rounded-md shadow-sm">
                        <input id="colText" v-model="colText" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="1/2,1/2" />
                    </div>
                </div>
                <div class="mt-5">
                    <label for="className" class="block text-sm font-medium leading-5 text-gray-700">HTML class for the row (optional)</label>
                    <div class="mt-2 relative rounded-md shadow-sm">
                        <input id="className" v-model="className" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="E.g. my-6" />
                    </div>
                </div>
            </div>
            <div class="py-6">
                <div class="text-sm font-bold text-gray-600 mb-2">Preview</div>
                <div class="preview px-6" ref="preview">
                    <div class="row flex items-start flex-wrap -mx-6 py-4" :class="className">
                        <div class="column px-6" :class="`md:w-${col}`" v-for="(col, index) in cols" :key="index">
                            <p>Enter content here...</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                    <button type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo transition ease-in-out duration-150 sm:text-sm sm:leading-5"
                        @click.prevent="insert"
                    >
                        Insert
                    </button>
                </span>
            </div>
        </div>
    </transition>
</div>
</template>
<style lang="scss">
.preview {
    .row {
        @apply bg-gray-100 rounded;
    }
    .column {
        @apply border-2 border-dashed border-gray-200 py-5;
    }
}
</style>
<script>
export default {
    data() {
        return {
            isOpen: false,
            editor: null,
            colText: '1/2,1/2',
            className: null,
            selection: null,
            element: null,
            isRoot: false
        };
    },
    created() {
        this.initBusListeners();
    },
    mounted() {

    },
    computed: {
        cols() {
            var cols = this.colText.split(',');
            return cols;
        }
    },
    methods: {
        initBusListeners() {
            window.bus.$on('article-insert-row', this.open);
        },
        open(payload) {
            if(typeof payload == 'undefined') {
                this.editor = this.$root.$refs.ArticleEditor.editor
                this.element = this.$root.$refs.ArticleEditor
                this.isRoot = true
            } else {
                this.editor = payload.editor
                this.element = payload.editorElement
                this.isRoot = false
            }

            this.selection = this.editor.exportSelection();
            this.editor.saveSelection();
            
            this.isOpen = true;
        },
        close() {
            this.isOpen = false;
            this.colText = '1/2,1/2';
        },
        insert() {
            /* this.editor.pasteHTML(, {
                cleanAttrs: []
            }, true); */
            this.$nextTick(() => {
                this.editor.restoreSelection();
                this.editor.pasteHTML(this.$refs.preview.innerHTML + "\n", {
                    cleanAttrs: []
                });
            });
        }
    }
}
</script>