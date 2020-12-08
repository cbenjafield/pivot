<template>
    <div class="p-3 bg-gray-50 rounded-md grid grid-cols-4 text-sm">
        <div class="col-span-3">
            {{ item.quantity }} x <strong>{{ item.name }}</strong>
        </div>
        <div class="text-right font-bold">
            £{{ item.price | price }}
        </div>
    </div>
</template>
<script>
export default {
    props: [
        'item',
    ],
    data() {
        return {
            //
        }
    },
    filters: {
        price(value) {
            return parseFloat(value).toFixed(2).replace('.00', '')
        }
    },
    computed: {
        //
    },
    methods: {
        //
    }
}
</script>