<template>
    <div>
        <input type="file" class="hidden" name="files" ref="fileInput" id="fileInput" multiple @change="fileChanged($event)">
        <div class="px-6 py-8 border border-dashed rounded-md text-gray-500 flex items-center justify-center" ref="dragArea">
            <span>Drop files here to upload</span>
        </div>
        <div class="mt-6" v-if="files.length">
            <div class="rounded-md bg-gray-50 mb-2 p-2" v-for="(file, key) in files" :key="key">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded mr-6 overflow-hidden flex items-center justify-center">
                        <img class="object-cover h-10 border-none" :ref="`preview-${parseInt(key)}`" v-if="isImage(key)">
                        <i class="far fa-file text-xl" v-else></i>
                    </div>
                    <div class="flex-1 mr-3">
                        <span class="font-semibold text-gray-700 text-sm block truncate">{{ file.obj.name }}</span>
                    </div>
                    <template v-if="!file.complete">
                        <div class="flex-shrink-0" v-if="file.valid">
                            <button type="button" class="h-6 w-6 flex items-center justify-center text-base" @click.prevent="removeFile(file.id)">
                                <span class="sr-only">Delete</span>
                                <i class="far fa-times"></i>
                            </button>
                        </div>
                        <div class="text-red-400 text-sm cursor-pointer" title="This image will not be uploaded." v-if="!file.valid && !file.error">
                            Not Allowed
                        </div>
                        <div class="flex-shrink-0" v-if="file.error">
                            <i class="fad fa-times-circle text-red-500 text-base"></i>
                        </div>
                    </template>
                    <template v-else>
                        <div class="flex-shrink-0">
                            <i class="far fa-check text-teal-400 text-base"></i>
                        </div>
                    </template>
                </div>
                <div class="mt-2" v-if="file.progress">
                    <div class="h-1 w-full rounded-full bg-gray-200 overflow-hidden">
                        <div class="bg-indigo-300 h-1" :style="`width:${file.progress}%`"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 flex justify-center" v-if="validFiles.length">
            <span class="inline-flex rounded-md shadow-sm w-full">
                <button type="button" class="inline-flex w-full items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150" v-if="!isUploading" @click.prevent="processUpload">
                    Upload Files
                </button>
                <span class="inline-flex w-full items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-gray-600 bg-gray-300" v-else>
                    <i class="far fa-cog fa-fw mr-3 fa-spin"></i> Working...
                </span>
            </span>
        </div>
    </div>
</template>
<script>
export default {
    props: [
        'website'
    ],
    data() {
        return {
            files: [],
            dragAndDropCapable: false,
            isUploading: false,
            attemptedCount: 0
        }
    },
    watch: {
        attemptedCount(value) {
            if(this.attemptedCount && this.attemptedCount == this.validFiles.length) {
                if(this.withErrors.length == 0) {
                    // this.fetchPhotos();
                    this.reset();
                }
                this.isUploading = false;
            }
        }
    },
    computed: {
        validFiles() {
            return this.files.filter(file => {
                return file.valid === true && file.complete === false;
            });
        },
        withErrors() {
            return this.files.filter(file => {
                return file.error === true;
            });
        }
    },
    mounted() {
        this.init();
    },
    methods: {
        determineDragAndDropCapable() {
            var div = document.createElement('div');

            return (('draggable' in div))
                    || ('ondragstart' in div && 'ondrop' in div)
                    && 'FormData' in window
                    && 'FileReader' in window;
        },
        init() {
            this.dragAndDropCapable = this.determineDragAndDropCapable();

            if(this.dragAndDropCapable) {
                ['drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop'].forEach((event) => {
                    this.$refs.dragArea.addEventListener(event, (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        if(event == 'dragover') {
                            this.dragAreaClass = 'border-teal-400';
                        }
                        if(event == 'dragleave' || event == 'drop') {
                            this.dragAreaClass = 'border-gray-300';
                        }
                    });
                });

                this.$refs.dragArea.addEventListener('drop', (e) => {
                    for(let i = 0; i < e.dataTransfer.files.length; i++) {
                        this.uploadFile(e.dataTransfer.files[i]);
                    }
                });
            }
        },
        fileChanged(event) {
            for(let i = 0; i < event.target.files.length; i++) {
                this.uploadFile(event.target.files[i]);
            }
        },
        uploadFile(file) {
            var index = this.files.length;
            this.files.push({
                obj: file,
                progress: 0,
                id: `photo-${index}`,
                valid: this.validatePhoto(file),
                error: false,
                complete: false
            });
            this.getImagePreviews();
        },
        validatePhoto(file) {
            return ['image/jpeg', 'image/png', 'video/mp4']
                        .indexOf(file.type) != -1;
        },
        isImage(index) {
            return /\.(jpe?g|png|gif)$/i.test(this.files[index].obj.name);
        },
        getImagePreviews() {
            for(let i = 0; i < this.files.length; i++) {
                if(this.isImage(i)) {
                    let reader = new FileReader();

                    reader.addEventListener('load', () => {
                        this.$refs[`preview-${i}`][0].src = reader.result;
                    }, false);

                    reader.readAsDataURL(this.files[i].obj);
                }
            }
        },
        removeFile(id) {
            this.files.splice(
                this.files.findIndex(file => file.id == id),
                1
            );
        },
        processUpload() {
            this.isUploading = true;

            this.validFiles.forEach(file => {
                this.uploadToServer(file);
            });
        },
        getFileIndex(id) {
            return this.files.findIndex(file => file.id === id);
        },
        uploadToServer(file) {
            if(file.complete) return false;
            
            var formData = new FormData;

            formData.append('file', file.obj);

            var _t = this;

            axios.post(`/websites/${this.website}/media`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress(progressEvent) {
                    _t.files[_t.getFileIndex(file.id)].progress = parseInt(
                        Math.round(
                            (progressEvent.loaded * 100) / progressEvent.total
                        )
                    );
                }
            }).then(response => {
                if(response.status == 201) {
                    this.files[this.getFileIndex(file.id)].error = false;
                    this.files[this.getFileIndex(file.id)].complete = true;
                    this.attemptedCount++;
                    this.$emit('file-uploaded', response.data.file);
                }
            }).catch(error => {
                if(error.response) {
                    this.files[this.getFileIndex(file.id)].error = true;
                    this.attemptedCount++;
                }
            });
        },
        reset() {
            this.files = [];
            this.attemptedCount = 0;
            this.isUploading = false;
        },
    }
}
</script>