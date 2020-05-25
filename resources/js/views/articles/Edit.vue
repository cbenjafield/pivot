<template>
<form class="flex items-stretch w-full" id="createArticleForm">
    <div class="flex-1 bg-white relative">
        <div class="md:flex md:items-center h-16">
            <label class="md:w-1/6 text-gray-500 md:p-3" for="title">
                Title
            </label>
            <div class="flex-1">
                <input id="title" v-model="title" required name="title" class="flex-1 h-16 block w-full rounded-none border-l border-gray-200 transition duration-150 ease-in-out sm:leading-5 outline-none px-3 text-base" placeholder="Enter title" @change="$root.slugify($event.target.value, '#slug')" />
            </div>
        </div>
        <div class="md:flex md:items-center h-16 border-t border-gray-200">
            <label class="md:w-1/6 text-gray-500 md:p-3" for="slug">
                Slug
            </label>
            <div class="flex-1">
                <input id="slug" v-model="slug" required name="slug" class="flex-1 h-16 block w-full rounded-none border-l border-gray-200 transition duration-150 ease-in-out sm:leading-5 outline-none px-3 text-base" placeholder="Enter slug" />
            </div>
        </div>
        <editor ref="ArticleEditor" v-model="content" />
    </div>
    <div class="w-1/3">
        <div class="w-full p-3">
            <div class="w-full mb-4 flex items-center">
                <span class="inline-flex rounded-md shadow-sm flex-1 mr-3">
                    <button type="button" class="flex w-full items-center px-6 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150" @click.prevent="save">
                        <span v-if="!isSaving">Save Changes</span>
                        <span v-else><i class="far fa-spinner-third fa-spin"></i> Saving</span>
                    </button>
                </span>
                <span class="inline-flex rounded-md shadow-sm">
                    <button type="button" class="flex w-full items-center px-6 py-2 border border-gray-300 text-base leading-6 font-medium rounded-md text-red-700 bg-white hover:text-red-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                        <i class="far fa-trash mr-2"></i> Delete
                    </button>
                </span>
            </div>
            <div class="w-full border-t border-dashed border-gray-200 pt-4">
                <input type="hidden" name="status" id="status" value="drafted">
                <div class="flex rounded-md shadow-sm mb-2">
                    <button type="button" class="inline-flex w-full items-center px-4 py-2 border border-gray-300 text-base leading-6 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150">
                        <i class="far fa-image-polaroid fa-fw mr-2"></i> Insert Image
                    </button>
                </div>
                <div class="flex rounded-md shadow-sm mb-2">
                    <button type="button" class="inline-flex w-full items-center px-4 py-2 border border-gray-300 text-base leading-6 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" @click.prevent="$root.busEvent('article-insert-row', $refs.ArticleEditor)">
                        <i class="far fa-arrows-h fa-fw mr-2"></i> Insert Row
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
</template>
<script>
export default {
    props: [
        'article',
        'action'
    ],
    data() {
        return {
            isSaveOpen: false,
            title: this.article.title,
            slug: this.article.slug,
            content: this.article.content,
            errors: [],
            isSaving: false,
        };
    },
    methods: {
        resetErrors() {
            this.errors = [];
        },
        save() {
            this.isSaving = true;

            if(!this.title) this.errors.push({
                field: 'title',
                message: 'Please enter a title.'
            });

            if(!this.slug) this.errors.push({
                field: 'slug',
                message: 'Please enter a slug.'
            });

            if(this.errors.length) return false;

            axios.put(this.action, {
                title: this.title,
                slug: this.slug,
                content: this.content,
            }).then(response => {
                if(response.status == 200) {
                    this.isSaving = false;
                }
            }).catch(error => {
                if(error.response) {
                    if(error.response.status == 422) {
                        // Validation errors
                    } else {
                        alert('A different error.');
                    }
                }
            })
        }
    }
}
</script>