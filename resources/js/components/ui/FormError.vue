<template>
    <span class="block mt-1 text-xs text-red-700" v-if="error">
        {{ error }}
    </span>
</template>
<script>
export default {
    props: [
        'error'
    ]
}
</script>