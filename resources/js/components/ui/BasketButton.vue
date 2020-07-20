<template>
    <button class="w-full p-3 text-white font-bold bg-gray-900" @click.prevent="addToBasket">
        <span v-if="!isAdding && !isAdded"><i class="far fa-shopping-basket fa-fw mr-2"></i> Add to basket</span>
        <span v-if="!isAdding && isAdded"><i class="far fa-check fa-fw mr-2"></i> Added to basket</span>
        <span v-if="isAdding"><i class="far fa-spinner-third fa-spin fa-fw mr-2"></i> Adding</span>
    </button>
</template>
<script>
export default {
    props: [
        'item'
    ],
    data() {
        return {
            isAdding: false,
            isAdded: false
        }
    },
    methods: {
        addToBasket() {
            this.isAdding = true;

            axios.post(`/basket/${this.item.content.itemid}`).then(response => {
                this.isAdded = true;
                this.isAdding = false;
            }).catch(error => {
                alert('An error occurred.');
            });
        }
    }
}
</script>
