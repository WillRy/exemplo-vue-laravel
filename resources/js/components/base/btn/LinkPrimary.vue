<template>
    <Link class="btn btn-nobg-primary" :class="{'btn-min': min, 'btn-full': full}">
        <slot></slot>
    </Link>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "LinkPrimary",
    components:{
        Link
    },
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
