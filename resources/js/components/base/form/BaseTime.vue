<template>
    <div :style="{'margin-bottom': mb, width: width}" class="form-group">
        <label v-if="label" :for="$attrs.id">{{ label }}</label>
        <DatePicker
            v-model="data"
            v-bind="attrs"
            is24hr
            mode="time"
        >
            <template v-slot="{ inputValue, inputEvents }">
                <input
                    v-if="!disabled"
                    v-on="inputEvents"
                    :value="inputValue"
                />
                <input
                    v-else
                    :value="formatado"
                    disabled
                />
            </template>
        </DatePicker>
        <div v-if="error || $slots.error" class="errorMessage">
            <div>{{ error }}</div>
            <slot name="error"></slot>
        </div>
    </div>
</template>

<script>
import {format, parseJSON} from 'date-fns'

export default {
    name: "BaseDate",
    inheritAttrs: false,
    props: {
        error: {
            default: null,
            type: String
        },
        label: {
            type: String,
            default: ''
        },
        modelValue: [String, Date],
        mb: {
            default: '20px'
        },
        width: {
            default: 'auto'
        },
        disabled: {
            default: false
        },
        formatado: {
            type: [String, Date]
        },
        timezone: {
            default: 'America/Sao_Paulo'
        }
    },
    computed: {
        attrs() {
            return {
                ...this.$attrs,
            }
        },
        data: {
            set(valor) {
                if (valor) {
                    let objeto = parseJSON(valor);
                    let string = format(valor, 'yyyy-MM-dd');
                    this.$emit('update:modelValue', objeto);
                    this.$emit('update:formatado', string);
                }
                return null;
            },
            get() {
                let valor = this.modelValue || this.formatado;
                if (valor) {
                    return parseJSON(valor)
                }
                return null;

            }
        },
    },
    watch: {
        data(valor) {
            let string = null;
            if (valor) {
                string = format(valor, 'yyyy-MM-dd');
            } else {
                string = null;
            }
            this.$emit('update:formatado', string);
        }
    },
    methods: {
        emitirData() {
            if (this.data) {
                this.$emit('update:modelValue', this.data);
                this.$emit('change', this.data);

                this.$emit('update:formatado', this.formatado);
                this.$emit('changeFormatado', this.formatado);
            }
        },
    },
    created() {
        this.emitirData();
    }
}
</script>
<style scoped>
.form-group label {
    font-weight: 700;
    font-size: 14px;
    color: var(--cor-label);
    margin-bottom: 8px;
    display: block;
    text-transform: capitalize;
}

.form-group input {
    background: #FFFFFF;
    border: 1px solid var(--cor-borda-principal);
    border-radius: var(--radius-principal);
    padding: 10px;
    display: block;
    width: 100%;
    height: 42px;
    color: #444444;
}

.form-group input::placeholder {
    font-family: 'Roboto', sans-serif;
    font-style: normal;
    font-weight: normal;
    font-size: 16px;
    color: var(--cor-placeholder);
}


/deep/ .errorMessage > div {
    margin: 3px 0;
    color: var(--cor-input-error);
}
</style>
