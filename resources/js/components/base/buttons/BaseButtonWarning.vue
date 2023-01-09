<template>
    <BaseButton class="btn-warning" :size="size" :min="min">
        <slot></slot>
    </BaseButton>
</template>

<script>
import BaseButton from "./BaseButton";

export default {
    name: "BaseButtonWarning",
    components: {BaseButton},
    props: {
        size: {
            type: String,
            default: 'md'
        },
        min: {
            type: String,
            default: ''
        }
    }
}
</script>

<style scoped>
.btn-warning {
    background: var(--warning-color-600);
    color: #000;
    border: 1px solid var(--warning-color-600);
}

.btn-warning:hover {
    background: var(--warning-color-400);
    color: #000;
    border: 1px solid var(--warning-color-400);
}

.btn-warning:focus-visible {
    border: 1px solid #fff;
    box-shadow: 0 0 0 2px var(--warning-color-600);
    background: var(--warning-color-400);
}

.btn-warning:active {
    background: var(--warning-color-700);
}

.btn-warning:disabled {
    background: var(--gray-200);
    color: var(--gray-300);
    cursor: not-allowed;
    border: none;
}
</style>
