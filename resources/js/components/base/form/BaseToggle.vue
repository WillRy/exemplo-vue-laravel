<template>
    <div :class="{checked: checked}" class="check-container">
        <span v-if="label" class="label">
            {{ label }}
        </span>
        <input
            ref="checkbox"
            v-bind="$attrs"
            :checked="checkedNormalizado"
            :disabled="disabled"
            class="check"
            type="checkbox"
            @change="updateValue"
        >

        <label class="checktoggle" @click="updateValue">
            <span :class="{visible: checkedNormalizado}" class="on">{{ on }}</span>
            <span :class="{visible: !checkedNormalizado}" class="off">{{ off }}</span>
        </label>
    </div>
</template>

<script>
export default {
    name: "BaseToggle",
    inheritAttrs: false,
    model: {
        prop: 'checked',
        event: 'change'
    },
    props: {
        checked: {
            type: [Boolean, String]
        },
        disabled: Boolean,
        label: String,
        on: {
            type: String,
            default: "ON"
        },
        off: {
            type: String,
            default: "OFF"
        },
    },
    computed: {
        checkedNormalizado() {
            if ((typeof this.checked === 'string' && this.checked === 'S') || (typeof this.checked === 'boolean' && this.checked)) {
                return true;
            }
            return false;
        }
    },
    methods: {
        updateValue() {
            if (this.disabled) return;

            let valor = !this.$refs.checkbox.checked;
            console.log(valor);
            this.$emit('change', valor)
        },
        normalizaPrimeiroValor() {
            if ((typeof this.checked === 'string' && this.checked === 'S') || (typeof this.checked === 'boolean' && this.checked)) {
                this.$emit('change', true);
            } else {
                this.$emit('change', false);
            }
        }
    },
    created() {
        // console.log('base', this.checked);
        this.normalizaPrimeiroValor();
    }
}
</script>

<style scoped>


.label {
    font-weight: 700;
    font-size: 14px;
    color: var(--cor-label);
    margin-bottom: 8px;
    display: block;
}

.check-container {
    position: relative;
}

.check-container .on {
    visibility: hidden;
    color: #BBBFC4;
    font-size: 12px;
    line-height: 0;
    user-select: none;
    margin-left: 12px;
}

.check-container .off {
    visibility: hidden;
    color: #BBBFC4;
    font-size: 12px;
    line-height: 0;
    user-select: none;
    margin-right: 12px;
}

.check {
    display: block;
    margin: 0;
    padding: 0;
    width: 0;
    height: 0;
    visibility: hidden;
    opacity: 0;
    pointer-events: none;
    position: absolute;
}

.check:disabled + .checktoggle {
    opacity: 0.4;
    cursor: not-allowed;
}

.check:checked + .checktoggle {
    background-color: var(--cor-principal);
    box-shadow: none;
}

.checktoggle {
    box-shadow: inset 0px 3px 6px #00000029;
    background-color: #F5F5F5;
    color: #BBBFC4;
    border-radius: 24px;
    cursor: pointer;
    display: flex;
    align-items: center;
    font-size: 0;
    min-height: 42px;
    margin-bottom: 0;
    position: relative;
    min-width: 82px;

    max-width: max-content;

    justify-content: space-between;
}

.checktoggle:after {
    content: ' ';
    display: block;
    position: absolute;
    top: 50%;
    left: 0;
    transform: translate(5px, -50%);
    width: 32px;
    height: 32px;
    background-color: var(--cor-principal);
    border-radius: 50%;
    transition: left 300ms ease, transform 300ms ease;
}


.check:checked + .checktoggle:after {
    background-color: #fff;
    left: 100%;
    transform: translate(calc(-100% - 5px), -50%);
}


.visible {
    visibility: visible !important;
}
</style>
