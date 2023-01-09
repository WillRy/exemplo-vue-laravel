<template>
    <BaseButton class="btn-secondary" :size="size" :min="min">
        <slot></slot>
    </BaseButton>
</template>

<script>
import BaseButton from "./BaseButton";

export default {
    name: "BaseButtonSecondary",
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
.btn-secondary {
    background: none;
    color: var(--primary-color-600);
    border: 1px solid var(--primary-color-600);
}

.btn-secondary:hover {
    background: none;
    border: 1px solid var(--primary-color-400);
    color: var(--primary-color-400);
}

.btn-secondary:focus-visible {
    color: #fff;
    border: 1px solid #fff;
    box-shadow: 0 0 0 2px var(--primary-color-600);
    background: var(--primary-color-400);
}

.btn-secondary:active {
    background: var(--primary-color-700);
    color: #fff;
}

.btn-secondary:disabled {
    background: var(--gray-200);
    color: var(--gray-300);
    cursor: not-allowed;
    border: none;
}
</style>
