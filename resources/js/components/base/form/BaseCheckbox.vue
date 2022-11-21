<template>
    <div :class="{ 'form-group-has-icon': $slots.icon }" :style="{ 'margin-bottom': mb, width: width }"
         class="form-group">
        <label class="checkbox blue">
            <input type="checkbox" id="checkbox" class="checkbox" v-model="modelValue" @input="updateValue"
                   v-bind="attrs">
            <span class="indicator"></span>
            <template v-if="label">{{ label }}</template>
        </label>
        <div v-if="error || $slots.error" class="errorMessage">
            <div>{{ error }}</div>
            <slot name="error"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "BaseCheckbox",
    inheritAttrs: false,
    props: {
        label: {
            type: String,
            default: ''
        },
        modelValue: {
            default: null
        },
        mb: {
            default: '0px'
        },
        width: {
            default: 'auto'
        },
        error: {
            type: String,
        }
    },
    computed: {
        attrs() {
            return {
                ...this.$attrs,
                input: this.updateValue
            }
        }
    },
    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', !event.target.value)
        }
    },
}
</script>

<style scoped>
.form-group {
    margin-bottom: 20px;
}


/deep/ .errorMessage > div {
    margin: 3px 0;
    color: var(--cor-input-error);
}
</style>
