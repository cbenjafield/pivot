<template>
    <div class="shadow-sm sm:rounded-md overflow-hidden mt-6">
        <div class="bg-white p-4">
            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start border-b border-gray-200 pb-5">
                <label for="title" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Title
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                        <input id="title" v-model="title" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" required />
                    </div>
                </div>
            </div>
            <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pb-5 border-b border-gray-200">
                <label for="email" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Email
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                        <input type="email" v-model="email" id="email" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    </div>
                    <p class="text-sm text-gray-500 mt-2">This will default to your email if not supplied.</p>
                </div>
            </div>
            <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:pb-5">
                <label for="webhook_url" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                    Webhook URL
                </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">
                    <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                        <input type="url" v-model="webhook_url" id="webhook_url" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                    </div>
                    <p class="text-sm text-gray-500 mt-2">If this is provided, an email will not be sent.</p>
                </div>
            </div>
        </div>

        <div class="border-t border-b border-gray-200">
            <div class="py-3 border-b last:border-b-0 px-4" v-for="field in fields" :key="field.id">
                <component :is="field.type" :field="field" />
            </div>
        </div>

        <div class="border-t border-gray-200 p-4 bg-gray-50">
            <span class="inline-flex rounded-md shadow-sm">
                <button type="button" class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-gray-700 transition duration-150 ease-in-out" @click.prevent="addField">
                    <i class="far fa-plus mr-1"></i> Add Field
                </button>
            </span>
            <span class="ml-3 inline-flex rounded-md shadow-sm">
                <button type="submit" class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out" @click.prevent="updateForm">
                    Save Form
                </button>
            </span>
        </div>
    </div>
</template>
<script>
import FormText from './fields/Text'
import FormEmail from './fields/Email'
import FormPhone from './fields/Phone'
import FormTextarea from './fields/Textarea'
import FormSelect from './fields/Select'

export default {
    props: [
        'website',
        'form',
    ],
    components: {
        FormText,
        FormEmail,
        FormPhone,
        FormTextarea,
        FormSelect,
    },
    data() {
        return {
            title: this.form.title || null,
            email: this.form.email || null,
            webhook_url: this.form.webhook_url || null,
            fields: []
        }
    },
    mounted() {
        this.setFields()
    },
    methods: {
        addField() {
            this.fields.push({
                id: `field-${window.randomString(8)}`,
                label: null,
                name: null,
                helptext: null,
                type: 'form-text',
                value: null,
                required: true,
                options: [],
            });
        },
        updateType(id, value) {
            const index = this.fields.findIndex(field => field.id == id);
            if(index == -1) {
                return false;
            }
            this.fields[index].type = value;
        },
        updateField(id, data) {
            const index = this.fields.findIndex(field => field.id == id);
            if(index == -1) {
                return false;
            }
            this.fields[index] = data;
            this.$forceUpdate();
        },
        updateForm() {
            if(!this.title) return alert('Please enter a title.');
            if(!this.email && !this.webhook_url) return alert('Please enter an email address or Webhook URL.');
            
            axios.put(`/websites/${this.website}/contact/${this.form.id}`, {
                title: this.title,
                email: this.email,
                webhook_url: this.webhook_url,
                fields: this.fields
            }).then(response => {
                if(response.status == 200) {
                    return location.reload();
                }
            }).catch(error => {
                return alert('An error occurred.');
            });
        },
        setFields() {
            if(typeof this.form.content == 'undefined' || ! this.form.content) return false;
            this.fields = JSON.parse(this.form.content);
        }
    }
}
</script>