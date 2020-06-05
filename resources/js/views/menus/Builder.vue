<template>
    <div>
        <div class="md:flex md:items-center md:justify-between bg-white p-6 border-b border-gray-200">
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold leading-7 text-gray-800 sm:text-3xl sm:leading-9 sm:truncate mb-2">
                    Add Menu
                </h1>
            </div>
            <div class="sm:ml-6">
                <span class="inline-flex rounded-md shadow-sm">
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150" @click.prevent="save">
                        Save Menu
                    </button>
                </span>
            </div>
        </div>

        <div class="flex flex-wrap items-start">

            <div class="w-full md:w-1/2 px-5">
                <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <h3 class="font-medium text-gray-900 mb-6 text-xl pb-4 border-b border-gray-200">Menu Details</h3>
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                            <label for="title" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                                Title
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="max-w-xs rounded-md shadow-sm">
                                    <input type="text" id="title" name="title" v-model="title" maxlength="255" class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" placeholder="E.g. Main Menu" />
                                </div>
                                <p class="mt-2 text-sm text-red-600 font-bold" v-if="error('title')">{{ error('title') }}</p>
                                <p class="mt-2 text-sm text-gray-500">This is the title of the menu.</p>
                            </div>
                        </div>
                        <div class="mt-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                            <label for="title" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
                                Position
                            </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="max-w-lg rounded-md shadow-sm sm:max-w-xs">
                                    <select id="position" v-model="position" class="block form-select w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                        <option value="primary">Primary - Header</option>
                                        <option value="secondary">Secondary - Footer</option>
                                    </select>
                                </div>
                                <p class="mt-2 text-sm text-red-600 font-bold" v-if="error('position')">{{ error('position') }}</p>
                                <p class="mt-2 text-sm text-gray-500">The menu can either be primary (header) or secondary (footer).</p>
                            </div>
                        </div>
                    </div>
                </div>
                <add-menu-item/>
            </div>

            <div class="w-full md:w-1/2 px-5">
                <div class="shadow sm:rounded-md sm:overflow-hidden mt-6">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="p-6 text-center text-base text-gray-500" v-if="!items.length">
                            No menu items have been added yet.
                        </div>
                        <div v-else>
                            <draggable v-model="items">
                                <transition-group>
                                    <div v-for="item in items" :key="item.id" class="flex items-center py-3 border-b border-gray-200 last:border-b-0">
                                        <span class="font-medium text-gray-900 w-1/2 mr-4">
                                            {{ item.title }}
                                        </span>
                                        <span class="text-gray-400 flex-1 text-right">{{ item.destination }}</span>
                                        <span class="text-gray-400 ml-3">
                                            <button type="button" class="p-2 cursor-pointer text-red-600" @click.prevent="remove(item.id)">
                                                <i class="far fa-times"></i>
                                            </button>
                                        </span>
                                    </div>
                                </transition-group>
                            </draggable>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import draggable from 'vuedraggable'
import AddItem from '../../components/menus/AddItem'

export default {
    props: [
        'siteId',
        'menu',
    ],
    components: {
        draggable,
        'add-menu-item': AddItem,
    },
    data() {
        return {
            items: [],
            errors: {},
            title: null,
            position: 'primary'
        }
    },
    mounted() {
        this.initBuilder();
    },
    computed: {
        isEditMode() {
            return !! (typeof this.menu != 'undefined' && this.menu);
        },
        sequencedItems() {
            var items = [];
            var index = 0;
            this.items.forEach(item => {
                index++;
                item.sequence = index;
                items.push(item);
            });

            return items;
        }
    },
    methods: {
        initBuilder() {
            if(typeof this.menu != 'undefined' && this.menu) {
                this.title = this.menu.title;
                this.position = this.menu.position;

                if(this.menu.items.length) {
                    this.menu.items.forEach(item => {
                        this.items.push({
                            title: item.title,
                            destination: item.destination,
                            id: item.id,
                            sequence: item.sequence
                        });
                    });
                }
            }
        },
        addItem(title, destination) {
            var sequence = this.items.length + 1;
            this.items.push({
                id: `item-${sequence}`,
                title: title,
                destination: destination,
                sequence: sequence,
            });
        },
        remove(id) {
            var itemIndex = this.items.findIndex(item => item.id === id);
            if(itemIndex == -1) return false;
            this.items.splice(itemIndex, 1);
        },
        error(field) {
            if(typeof this.errors[field] != 'undefined') {
                return this.errors[field][0];
            }
            return null;
        },
        save() {
            this.errors = {};

            if(!this.title) {
                this.errors.title = ['Please enter a title.']
                return false;
            }

            var url = this.isEditMode ? `/websites/${this.siteId}/menus/${this.menu.id}`
                                      : `/websites/${this.siteId}/menus`;

            if(this.isEditMode) {
                axios.put(url, {
                    title: this.title,
                    items: this.sequencedItems,
                    position: this.position
                }).then(response => {
                    if(response.status == 200) {
                        return window.location.reload();
                    }
                }).catch(error => {
                    if(error.response) {
                        alert('An error occurred.')
                    }
                });
            } else {
                axios.post(url, {
                    title: this.title,
                    items: this.sequencedItems,
                    position: this.position
                }).then(response => {
                    if(response.status == 201) {
                        return window.location.href = response.data.redirect_url || `websites/${this.site_id}/menus`;
                    }
                }).catch(error => {
                    if(error.response) {
                        alert('An error occurred.')
                    }
                });
            }
        }
    }
}
</script>