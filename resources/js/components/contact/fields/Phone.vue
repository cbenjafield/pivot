<template>
    <div>
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
            <label class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                Name
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                    <input v-model="name" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                </div>
            </div>
        </div>
        <div class="mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
            <label class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                Label
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                    <input v-model="label" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                </div>
            </div>
        </div>
        <div class="mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
            <label for="first_name" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                Field Type
            </label>
            <div class="mt-1 sm:mt-0 sm:col-span-2">
                <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                    <field-types v-model="type" />
                </div>
            </div>
        </div>
        <div class="mt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-baseline">
            <div>
                <div class="text-base leading-6 font-medium text-gray-900 sm:text-sm sm:leading-5 sm:text-gray-700" id="label-email">
                    Is this field required?
                </div>
            </div>
            <div class="mt-4 sm:mt-0 sm:col-span-2">
                <div class="max-w-lg">
                    <div class="relative flex items-start">
                        <div class="absolute flex items-center h-5">
                            <input type="checkbox" v-model="required" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                        </div>
                        <div class="pl-7 text-sm leading-5">
                            <label class="font-medium text-gray-700">Required</label>
                            <p class="text-gray-500">Is this field required?</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import FieldTypes from '../FieldTypes'

export default {
    props: [
        'field',
    ],
    components: {
        FieldTypes,
    },
    data() {
        return {
            name: this.field.name || null,
            label: this.field.label || null,
            id: this.field.id || null,
            helptext: this.field.helptext || null,
            type: this.field.type || 'form-phone',
            value: this.field.value || null,
            required: this.field.required || false,
            options: this.field.options || [],
        }
    },
    watch: {
        type(value) {
            this.$parent.updateType(this.id, value)
        }
    },
    updated() {
        this.updateParent()
    },
    methods: {
        updateParent() {
            this.$parent.updateField(this.id, this.$data);
        }
    }
}
</script>