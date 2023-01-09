<template>
    <BaseButton class="btn-danger" :size="size" :min="min">
        <slot></slot>
    </BaseButton>
</template>

<script>
import BaseButton from "./BaseButton";

export default {
    name: "BaseButtonDanger",
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
.btn-danger {
    background: var(--error-color-600);
    color: #fff;
    border: 1px solid var(--error-color-600);
}

.btn-danger:hover {
    background: var(--error-color-400);
    color: #fff;
    border: 1px solid var(--error-color-400);
}

.btn-danger:focus-visible {
    border: 1px solid #fff;
    box-shadow: 0 0 0 2px var(--error-color-600);
    background: var(--error-color-400);
}

.btn-danger:active {
    background: var(--error-color-700);
}

.btn-danger:disabled {
    background: var(--gray-200);
    color: var(--gray-300);
    cursor: not-allowed;
    border: none;
}
</style>
