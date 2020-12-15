<template>
    <div>
        <div>
            <div class="bg-white rounded-md shadow overflow-hidden flex items-start space-x-4 p-3" v-for="field in meta" :key="field.id">
                <div class="flex-1">
                    <input type="text" v-model="field.key" class="form-input w-full transition duration-150 ease-in-out text-sm" placeholder="Key">
                    <textarea v-model="field.value" class="form-input w-full mt-1 transition duration-150 ease-in-out text-sm" placeholder="Value"></textarea>
                </div>
                <button class="text-sm w-5 h-5 text-gray-500 appearance-none focus:outline-none" @click.prevent="removeMeta(field.id)">
                    <i class="far fa-times"></i>
                </button>
            </div>
        </div>
        <div class="mt-4">
            <button class="appearance-none text-gray-900 text-sm focus:outline-none flex items-center space-x-2" @click.prevent="addMetaField">
                <i class="far fa-plus"></i><span>Add Custom Field</span>
            </button>
        </div>
    </div>
</template>
<script>
export default {
    props: [
        'value',
    ],
    data() {
        return {
            meta: this.value
        }
    },
    watch: {
        meta(value) {
            this.$emit('input', value)
        }
    },
    methods: {
        addMetaField() {
            this.meta.push({
                id: `amt-${window.randomString(6)}`,
                key: null,
                value: null,
            })
        },
        removeMeta(id) {
            let index = this.meta.findIndex(item => item.id == id)

            if(index != -1) {
                this.meta.splice(index, 1)
            }
        }
    }
}
</script>