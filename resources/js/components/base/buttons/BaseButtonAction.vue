<template>
    <BaseButton class="btn-action" :size="size" :min="min">
        <slot name="default"></slot>
    </BaseButton>
</template>

<script>
import BaseButton from "./BaseButton";

export default {
    name: "BaseButtonAction",
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
.btn-action {
    background: var(--second-color-600);
    color: #fff;
    border: 1px solid var(--second-color-600);
}

.btn-action:hover {
    background: var(--second-color-400);
    color: #fff;
    border: 1px solid var(--second-color-400);
}

.btn-action:focus-visible {
    border: 1px solid #fff;
    box-shadow: 0 0 0 2px var(--second-color-600);
    background: var(--second-color-400);
}

.btn-action:active {
    background: var(--second-color-700);
}

.btn-action:disabled {
    background: var(--gray-200);
    color: var(--gray-300);
    cursor: not-allowed;
    border: none;
}
</style>
