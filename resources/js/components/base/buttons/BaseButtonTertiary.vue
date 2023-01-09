<template>
    <BaseButton class="btn-tertiary" :size="size" :min="min">
        <slot></slot>
    </BaseButton>
</template>

<script>
import BaseButton from "./BaseButton";

export default {
    name: "BaseButtonTertiary",
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
.btn-tertiary {
    background: none;
    color: var(--primary-color-600);
    border: 1px solid transparent;
}

.btn-tertiary:hover {
    background: none;
    color: var(--primary-color-400);
    border: 1px solid var(--primary-color-400);
}

.btn-tertiary:focus-visible {
    color: #fff;
    border: 1px solid #fff;
    box-shadow: 0 0 0 2px var(--primary-color-600);
    background: var(--primary-color-400);
}

.btn-tertiary:active {
    background: var(--primary-color-700);
    color: #fff;
    border: 1px solid var(--primary-color-700);
}

.btn-tertiary:disabled {
    background: var(--gray-200);
    color: var(--gray-300);
    cursor: not-allowed;
    border: none;
}
</style>
