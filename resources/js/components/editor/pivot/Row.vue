<template>
    <div>
        <div class="row mb-4">
            <div class="flex items-center text-sm">
                <div class="drag-handle bg-gray-200 text-gray-400 px-3 py-2">
                    <i class="far fa-hand-paper"></i>
                </div>
                <div class="flex-1 pl-4">
                    <button type="button" class="text-gray-500" @click.prevent="isOptionsOpen = true">
                        <i class="far fa-cog mr-1"></i> Options
                    </button>
                </div>
            </div>
            <div class="row-content flex flex-wrap -mx-3">
                <pivot-column :column="col" v-for="col in cols" :key="col.id" :ref="col.id" />
            </div>
            <div class="mt-2 flex items-center text-sm">
                <div class="flex-1 mr-6">
                    <button type="button" class="text-indigo-500 mr-2" @click.prevent="addColumn">
                        <i class="far fa-plus mr-1"></i> Add Column
                    </button>
                </div>
                <div>
                    <button type="button" class="text-gray-500" @click.prevent="remove">
                        <i class="far fa-times mr-1"></i> Remove
                    </button>
                </div>
            </div>
        </div>
        <transition
            enter-active-class="ease-out duration-300"
            enter-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="ease-in duration-200"
            leave-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div class="fixed inset-0 z-front flex items-center justify-center overflow-y-auto p-6" v-if="isOptionsOpen">
                <div class="w-full max-w-3xl rounded-md shadow-lg sm:overflow-hidden">
                    <div class="bg-white p-4">
                        <div class="flex items-center mb-4">
                            <div class="flex-1 font-medium text-lg">
                                Row Options
                            </div>
                            <button type="button" class="text-gray-400 flex items-center justify-center text-lg" @click.prevent="isOptionsOpen = false">
                                <i class="far fa-times"></i>
                            </button>
                        </div>
                        <div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="classNames" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                                    Class Names
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                        <input id="classNames" v-model="classNames" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">The class name for the row.</p>
                                </div>
                            </div>
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="sectionClassNames" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                                    Section Class Names
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                        <input id="sectionClassNames" v-model="sectionClassNames" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">The class name for the row's housing section.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <span class="inline-flex rounded-md shadow-sm">
                            <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out" @click.prevent="isOptionsOpen = false">
                                Save & Close
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
<script>
export default {
    props: [
        'block'
    ],
    data() {
        return {
            cols: [],
            classNames: this.block.classNames,
            sectionClassNames: this.block.sectionClassNames,
            isOptionsOpen: false
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
            var object = {
                id: this.block.id,
                type: this.block.type,
                blocks: [],
                classNames: this.classNames,
                sectionClassNames: this.sectionClassNames
            };

            this.cols.forEach((col) => {
                let ref = this.$refs[col.id][0];
                object.blocks.push(ref.json());
            });

            return object;
        },
        setContent() {
            let content = this.block.content;
            if(!content) {
                this.cols = [
                    {
                        id: `col-${window.randomString(8)}`,
                        initialWidth: '1/2'
                    },
                    {
                        id: `col-${window.randomString(8)}`,
                        initialWidth: '1/2'
                    }
                ];
                return false;
            }

            this.cols = [];

            content.forEach(column => {
                let col = {
                    id: column.id,
                    type: 'pivot-column',
                    initialWidth: column.width,
                    content: column.blocks
                };

                this.cols.push(col);
            });
        },
        addColumn() {
            this.cols.push({
                id: `col-${window.randomString(8)}`,
                type: 'pivot-column',
                initialWidth: '1/2'
            });
        },
        removeColumn(id) {
            this.cols.splice(this.cols.findIndex(col => col.id === id), 1);
        }
    }
}
</script>