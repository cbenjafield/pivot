<template>
    <div>
        <h3 class="font-medium text-gray-900">Parent</h3>

        <input type="hidden" name="parent_id" :value="parent.id" v-if="parent">

        <div class="mt-2 relative">
            <input type="text" name="parentTerm" id="parentTerm" ref="parentTerm" class="form-input transition duration-150 ease-in-out w-full pr-10" placeholder="Search for parent page..." @input="updateValue($event.target.value)">
            <span class="absolute inset-y-0 right-0 w-10 flex items-center justify-center text-gray-400">
                <i class="far fa-search" v-if="! isSearching"></i>
                <i class="far fa-spinner-third fa-spin" v-else></i>
            </span>
        </div>
        <div class="rounded-md bg-white border border-gray-200 p-2 mt-2" v-if="result.length">
            <div class="rounded-md bg-gray-100 shadow-sm overflow-hidden p-2 hover:bg-indigo-100 transition duration-150 ease-in-out cursor-pointer" v-for="art in result" :key="art.id" @click.prevent="chooseParent(art)">
                <span class="block font-semibold text-gray-900 w-full truncate">{{ art.title }}</span>
                <span class="text-xs text-blue-500 block truncate">/{{ art.url }}</span>
            </div>
        </div>

        <div class="rounded-md bg-white p-2 mt-2 flex items-start" v-if="parent">
            <div class="flex-1">
                <span class="block font-bold w-full text-sm truncate text-gray-900">{{ parent.title }}</span>
                <span class="block text-blue-500 text-xs w-full truncate">/{{ parent.url }}</span>
            </div>
            <button class="appearance-none focus:outline-none text-red-600 text-sm w-6 h-6 flex items-center justify-center" type="button" @click.prevent="removeParent">
                <i class="far fa-times"></i>
            </button>
        </div>
    </div>
</template>
<script>
export default {
    props: [
        'site',
        'chosenParent',
        'article'
    ],
    data() {
        return {
            timer: null,
            isSearching: false,
            parent: this.chosenParent,
            result: [],
        }
    },
    methods: {
        updateValue(value) {
            clearTimeout(this.timer)
            this.timer = null

            if(! value) {
                this.results = []
                return
            }

            this.timer = setTimeout(() => {
                this.doneTyping(value)
            }, 300)
        },
        doneTyping(value) {
            this.isSearching = true

            axios.get(`/websites/${this.site}/articles/search`, {
                params: {
                    term: value,
                    parent: this.parent || null,
                    article: this.article || null
                }
            }).then(response => {
                this.result = response.data.articles
                this.isSearching = false
            }).catch(error => {
                //
            })
        },
        chooseParent(parent) {
            this.parent = parent
            this.$emit('input', parent.id)
            this.result = []
        },
        removeParent() {
            this.parent = null
            this.$emit('input', null)
            this.result = []
        }
    }
}
</script>