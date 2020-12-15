<template>
<div class="flex items-stretch w-full" id="createArticleForm">
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
            <div class="w-full mb-4 flex rounded-md shadow-sm">
                <label class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm" for="status">
                    Status
                </label>
                <select name="status" id="status" v-model="status" class="block form-select w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 rounded-l-none">
                    <option value="drafted">Draft</option>
                    <option value="published">Publish</option>
                </select>
            </div>

            <div class="w-full mb-4 flex items-center">
                <span class="inline-flex rounded-md shadow-sm flex-1 mr-3">
                    <button type="button" class="flex w-full items-center px-6 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150" @click.prevent="save">
                        <span v-if="!isSaving">Save Changes</span>
                        <span v-else><i class="far fa-spinner-third fa-spin"></i> Saving</span>
                    </button>
                </span>
                <span class="inline-flex rounded-md shadow-sm">
                    <button type="button" class="flex w-full items-center px-6 py-2 border border-gray-300 text-base leading-6 font-medium rounded-md text-red-700 bg-white hover:text-red-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" @click.prevent="deleteArticle">
                        <i class="far fa-trash mr-2"></i> Delete
                    </button>
                </span>
            </div>

            <div class="w-full mb-4 flex items-center">
                <a :href="article.url" class="flex w-full items-center px-6 py-2 border border-gray-300 text-base leading-6 font-medium rounded-md text-red-700 bg-white hover:text-red-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" target="_blank">
                    <span>View page on website</span>
                </a>
            </div>

            <div class="w-full mb-4">
                <article-parent :site="article.site_id" :chosen-parent="article.parent" :article="article.id" v-model="parent_id" />
            </div>

            <div class="w-full mb-4 mt-4">
                <h3 class="text-lg font-semibold text-gray-500 mb-4">SEO Details</h3>

                <article-seo-title :site="article.site_id" v-model="seo_title" />
                <article-seo-description :site="article.site_id" v-model="description" class="mt-3" />
            </div>

            <div class="w-full mb-4 mt-4">
                <h3 class="text-lg font-semibold text-gray-500 mb-4">Custom Fields</h3>

                <article-meta v-model="meta" />
            </div>
        </div>
    </div>
</div>
</template>
<script>
import ArticleSeoTitle from '../../components/articles/title'
import ArticleSeoDescription from '../../components/articles/description'
import ArticleMeta from '../../components/editor/pivot/Meta'

export default {
    components: {
        ArticleSeoTitle,
        ArticleSeoDescription,
        ArticleMeta,
    },
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
            status: this.article.status,
            parent_id: this.article.parent_id,
            seo_title: this.article.seo_title,
            description: this.article.description,
            meta: this.article.meta,
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

            // console.log(this.$refs.ArticleEditor.getContent());

            axios.put(this.action, {
                title: this.title,
                slug: this.slug,
                content: this.$refs.ArticleEditor.getContent(),
                status: this.status,
                parent_id: this.parent_id,
                description: this.description,
                seo_title: this.seo_title,
                meta: this.meta,
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
            });
        },

        deleteArticle() {
            axios.delete(`/websites/${this.article.site_id}/articles/${this.article.id}`)
                    .then(response => window.location.href=`/websites/${this.article.site_id}/articles`)
                    .catch(error => alert('An error occurred.'))
        }
    }
}
</script>