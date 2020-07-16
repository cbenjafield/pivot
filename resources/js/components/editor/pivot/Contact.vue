<template>
    <div>
        <div class="my-2">
            <div class="flex items-center text-sm">
                <div class="column-drag-handle bg-gray-200 text-gray-400 px-3 py-2">
                    <i class="far fa-hand-paper"></i>
                </div>
                <div class="flex-1 pl-4">
                    <button type="button" class="text-gray-500" @click.prevent="isOptionsOpen = true">
                        <i class="far fa-cog mr-1"></i> Options
                    </button>
                </div>
            </div>
            <div class="border border-gray-200 p-2">
                <div class="w-full rounded-md shadow-sm">
                    <select v-model="form" class="block w-full form-select w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                        <option :value="null">Please Select</option>
                        <option :value="form.id" v-for="form in forms" :key="form.id">{{ form.title }}</option>
                    </select>
                </div>
            </div>
            <div class="mt-2 flex items-center text-sm">
                <div class="flex-1 mr-6">

                </div>
                <div>
                    <button type="button" class="text-gray-500" @click.prevent="remove">
                        <i class="far fa-times mr-1"></i> Remove
                    </button>
                </div>
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
            className: null,
            form: null,
            forms: []
        };
    },
    computed: {
        siteId() {
            return window.siteId || null;
        }
    },
    mounted() {
        this.setContent();
        this.fetchForms();
    },
    created() {
        
    },
    methods: {
        remove() {
            this.$parent.$parent.removeBlock(this.block.id);
        },
        json() {
            return {
                id: this.block.id,
                type: 'pivot-contact',
                content: {
                    className: this.className,
                    form: this.form
                }
            };
        },
        setContent() {
            console.log(this.block.content)
            if(this.block.content) {
                this.className = this.block.content.className;
                this.form = this.block.content.form;
            }
        },
        fetchForms() {
            axios.get(`/websites/${this.siteId}/contact`).then(response => {
                this.forms = response.data.forms;
            }).catch(error => {
                alert('An error occurred.');
            });
        }
    }
}
</script>