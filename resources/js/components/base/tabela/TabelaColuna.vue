<template>
    <td :style="{'max-width': width}" class="td-oculta-texto">
        <div class="item">
            <div class="item-query">
                <span class="overflow">
                    <slot></slot>
                </span>
                <button class="btn-no-icon" @click="click" v-if="btn">
                    <img src="/img/eye.svg" alt="">
                </button>
            </div>
        </div>
    </td>
</template>

<script>
export default {
    name: "TabelaColuna",
    props: {
        width: {
            default: null
        },
        btn: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        click() {
            this.$emit('onVer');
        }
    }
}
</script>

<style scoped>

.td-oculta-texto .item {
    display: block;
}

.td-oculta-texto .overflow {
    display: block;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.overflow {
    display: block;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.item-query {
    display: flex;
    align-items: center;
    gap: 10px;
}

.item-query .btn-no-icon {
    width: 18px;
    flex-shrink: 0;
}

.btn-no-icon img {
    height: 18px;
    width: 18px
}
</style>
