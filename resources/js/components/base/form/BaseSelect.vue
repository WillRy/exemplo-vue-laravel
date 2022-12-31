<template>
    <div :style="{'margin-bottom': mb, width: width}" class="form-group">
        <label v-if="label" :for="$attrs.id">{{ label }}</label>
        <VueMultiselect
            v-bind="attrs"
            :allow-empty="empty"
            :deselectLabel="remover ? 'Remover' : ''"
            :label="textBy"
            :model-value="modelValue"
            :options="options"
            :searchable="search"
            :track-by="trackBy"
            deselectGroupLabel=""
            selectGroupLabel=""
            selectLabel=""
            selectedLabel=""
            @update:model-value="updateValue"
            :placeholder="placeholder"
            :limitText="count => `e mais ${count}`"
        >
            <template v-if="noOptions" #noOptions>
                {{ noOptions }}
            </template>
            <template v-if="noResult" #noResult>
                {{ noResult }}
            </template>
            <template v-slot:clear="" v-if="modelValue && remover">
                <button class="btn-remover-select" @click="updateValue(null)">x</button>
            </template>
        </VueMultiselect>
        <div v-if="error || $slots.error" class="errorMessage">
            <div>{{ error }}</div>
            <slot name="error"></slot>
        </div>
    </div>
</template>

<script>
import VueMultiselect from 'vue-multiselect'

export default {
    name: "BaseSelect",
    inheritAttrs: false,
    components: {
        VueMultiselect
    },
    props: {
        placeholder: {
            default: 'Selecione um valor'
        },
        noResult: {
            type: String,
            default: 'Não foram encontrados itens com esta pesquisa'
        },
        noOptions: {
            type: String,
            default: 'Digite sua pesquisa'
        },
        label: {
            type: String,
            default: ''
        },
        modelValue: {
            type: Object
        },
        mb: {
            default: '20px'
        },
        width: {
            default: 'auto'
        },
        trackBy: {
            type: String
        },
        textBy: {
            type: String
        },
        options: {
            type: Array
        },
        search: {
            type: Boolean,
            default: true
        },
        empty: {
            type: Boolean,
            default: false
        },
        error: {
            type: String,
            default: null
        },
        remover: {
            type: Boolean,
            default: false
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
        remove() {
            this.$emit('update:modelValue', null)
            this.$emit('change', null)
        },
        updateValue(event) {
            this.$emit('update:modelValue', event)
            this.$emit('change', event)
        }
    },
}
</script>
<style scoped>

label {
    font-weight: 700;
    font-size: 14px;
    color: var(--cor-label);
    margin-bottom: 8px;
    display: block;
}

/deep/ .errorMessage > div {
    margin: 3px 0;
    color: var(--cor-input-error);
}

.destaque-remover {
    color: var(--cor-danger);
}

.multiselect__option--highlight .destaque-remover {
    color: #fff;
}

.btn-remover-select {
    position: absolute;
    right: 34px;
    top: 10px;
    z-index: 9;
    background: var(--cor-danger);
    color: #fff;
    font-weight: bold;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

</style>
