<template>
    <button class="btn btn-secondary" :class="{'btn-min': min, 'btn-full': full}">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "ButtonPrimary",
    props: {
        min: {
            type: Boolean,
            default: true
        },
        full: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>

</style>
