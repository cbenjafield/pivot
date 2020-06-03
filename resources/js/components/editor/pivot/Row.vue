<template>
    <div class="row mb-4">
        <div class="row-content flex flex-wrap -mx-3">
            <pivot-column :column="col" v-for="col in cols" :key="col.id" :ref="col.id" />
        </div>
        <div class="mt-2 flex items-center text-sm">
            <div class="flex-1 mr-6">
                <button type="button" class="text-indigo-500" @click.prevent="addColumn">
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
</template>
<script>
export default {
    props: [
        'block'
    ],
    data() {
        return {
            cols: [],
            classNames: null
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
                blocks: []
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
        }
    }
}
</script>