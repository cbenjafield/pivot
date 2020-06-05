<template>
    <div>
        <div class="max-w-7xl mx-auto px-4 flex items-center sm:px-6 md:px-8">
            <div class="flex-1">
                <h1 class="text-2xl font-semibold text-gray-900">Media Library</h1>
            </div>
            <div>
                <span class="inline-flex rounded-md shadow-sm">
                    <label for="fileInput" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150 cursor-pointer">
                        <i class="far fa-upload mr-2"></i> Upload New
                    </label>
                </span>
            </div>
        </div>
        <div class="mt-6 max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <div class="shadow-sm rounded-md sm:overflow-hidden">
                <div class="bg-white p-3">
                    <uploader ref="uploader" :website="website" />
                </div>
            </div>
        </div>
        <div class="mt-6 max-w-7xl mx-auto px-4 sm:px-6 md:px-8" v-if="data">
            <div class="grid grid-cols-4 gap-4" v-if="!isFetching">
                <media-item :file="file" v-for="file in data.data" :key="file.id" :show-chooser="showChooser" />
            </div>
            <div class="bg-white p-3 rounded-md shadow-sm text-center" v-else>
                <i class="far fa-spinner-third fa-spin mr-2"></i> Loading
            </div>
        </div>
    </div>
</template>
<script>
import uploader from '../../components/media/Uploader'
import item from '../../components/media/Item'

export default {
    props: {
        website: {
            type: Number,
            default: null
        },
        showChooser: {
            type: Boolean,
            default: false
        },
        blockId: {
            type: String,
            default: null
        }
    },
    components: {
        uploader,
        'media-item': item,
    },
    data() {
        return {
            data: null,
            isFetching: true
        };
    },
    mounted() {
        this.fetchMedia();
        this.$refs.uploader.$on('file-uploaded', (payload) => {
            this.data.data = [payload, ...this.data.data];
        });
    },
    methods: {
        fetchMedia() {
            this.isFetching = true;

            axios.get(`/websites/${this.website}/media/all`).then(response => {
                if(response.status == 200) {
                    this.data = response.data;
                    this.isFetching = false;
                }
            }).catch(error => {

            });
        }
    }
}
</script>