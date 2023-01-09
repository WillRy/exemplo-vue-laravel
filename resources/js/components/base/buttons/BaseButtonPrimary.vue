<template>
    <BaseButton class="btn-primary" :size="size" :min="min">
        <slot></slot>
    </BaseButton>
</template>

<script>
import BaseButton from "./BaseButton";

export default {
    name: "BaseButtonPrimary",
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
.btn-primary {
    background: var(--primary-color-600);
    color: #fff;
    border: 1px solid var(--primary-color-600);
}

.btn-primary:hover {
    background: var(--primary-color-400);
    color: #fff;
}

.btn-primary:focus-visible {
    border: 1px solid #fff;
    box-shadow: 0 0 0 2px var(--primary-color-600);
    background: var(--primary-color-400);
}

.btn-primary:active {
    background: var(--primary-color-700);
}

.btn-primary:disabled {
    background: var(--gray-200);
    color: var(--gray-300);
    cursor: not-allowed;
    border: none;
}
</style>
