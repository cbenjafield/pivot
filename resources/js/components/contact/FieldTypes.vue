<template>
    <select class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" @change="onChange($event.target.value)" :value="value">
        <option v-for="field in fields" :key="field.component" :value="field.component">{{ field.label }}</option>
    </select>
</template>
<script>
export default {
    props: [
        'value'
    ],
    data() {
        return {
            selected: 'form-text',
            fields: [
                {
                    label: 'Text',
                    component: 'form-text',
                },
                {
                    label: 'Email',
                    component: 'form-email',
                },
                {
                    label: 'Textarea',
                    component: 'form-textarea',
                },
                {
                    label: 'Phone',
                    component: 'form-phone',
                }
            ]
        }
    },
    methods: {
        onChange(value) {
            this.$emit('input', value)
        }
    }
}
</script>