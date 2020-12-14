<template>
    <div>
        <div class="relative">
            <textarea rows="3" :value="value" class="form-input transition duration-150 w-full text-sm pr-8" placeholder="SEO Description" @input="e => updateValue(e.target.value)"></textarea>
            <span class="absolute bottom-0 right-0 w-8 h-10 pointer-events-none flex items-center justify-center">
                <span class="w-3 h-3 rounded-full" :class="`bg-${colour}`"></span>
            </span>
        </div>
        <div class="text-xs text-gray-600 bg-white shadow p-3 -mt-2 flex items-start space-x-4">
            <div class="flex-1">
                <p>The optimal length of a meta description is between 50-160 characters.</p>
                <a href="https://moz.com/learn/seo/meta-description" target="_blank" class="text-indigo-600">View on Moz.com <i class="far fa-long-arrow-right"></i></a>
            </div>
            <span class="font-bold" :class="`text-${colour}`">
                {{ length }}
            </span>
        </div>
    </div>
</template>
<script>
export default {
    props: [
        'value'
    ],
    computed: {
        colour() {
            if(! this.value) return 'gray-300'

            let length = this.value.length

            if(length < 40 || length > 160) {
                return 'red-600'
            }

            if(length < 70 || length > 155) {
                return 'orange-400'
            }

            return 'teal-400';
        },
        length() {
            if(! this.value) return 0

            return this.value.length
        }
    },
    methods: {
        updateValue(value) {
            this.$emit('input', value)
        }
    }
}
</script>