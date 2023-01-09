<template>
    <button
        class="btn"
        :class="{
            'btn-min-width': min,
            'btn-sm': size === 'sm',
            'btn-md': size === 'md',
            'btn-lg': size === 'lg',
            'btn-full': full
        }"
    >
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "BaseButton",
    props: {
        size: {
            type: String,
            default: 'md'
        },
        type: {
            type: String,
            default: 'primary'
        },
        min: {
            type: Boolean,
            default: false
        },
        full: {
            type: Boolean,
            default: false
        }
    },
    computed: {}
}
</script>

<style scoped>
.btn {
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    font-weight: bold;
    cursor: pointer;
    border-radius: 4px;
    outline: 0;
    gap: 10px;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.btn-sm {
    font-size: 16px;
    padding: 6px;
}

.btn-md {
    font-size: 14px;
    padding: 10px 20px;
    min-height: 36px;
}

.btn-lg {
    font-size: 16px;
    padding: 10px 20px;
    min-height: 42px;
}

.btn-min-width {
    min-width: 100px;
}

.btn-full {
    width: 100%;
}


</style>
