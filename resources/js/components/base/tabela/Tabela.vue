<template>
    <table class="tabela" :class="{loading: loading}">
        <thead>
        <TabelaHeadSort
            @onSort="sortBy(coluna.nome)"
            v-for="(coluna,index) in colunas"
            :info="coluna.info"
            :key="index"
            :nome="coluna.nome"
            :texto="coluna.texto"
            :ordenando="sortName"
            :order="sortOrder"
        />
        <slot name="acoes" v-if="$slots.acoes">
        </slot>
        </thead>
        <tbody v-if="dados && dados.length">
        <slot name="colunas" :dados="dados"></slot>
        </tbody>
        <tbody v-if="(!dados && !loading ) || (dados && !dados.length && !loading)"
               class="tabela-vazia">
        <tr>
            <td colspan="99999">{{ textoEmpty }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import TabelaHeadSort from "./TabelaHeadSort";

export default {
    name: "Tabela",
    components: {TabelaHeadSort},
    props: {
        textoEmpty: {
            type: String,
            default: 'Não há dados'
        },
        loading: {
            type: Boolean,
            default: false
        },
        colunas: {
            type: Array,
            default: []
        },
        dados: {
            type: Array,
            default: []
        },
        total: {
            type: Number,
            default: 0
        },
        perPage: {
            type: Number,
            default: 10
        },
        sortName: {
            type: String,
            default: null
        },
        sortOrder: {
            type: String,
            default: 'asc'
        },
    },
    data() {
        return {}
    },
    methods: {
        sortBy(campo) {
            let sortName = campo;
            let sortOrder = this.sortOrder;

            sortName = campo;
            if (sortName !== campo) {
                sortOrder = "asc";
            } else {
                sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
            }

            this.$emit("onSort", {
                sortName: sortName,
                sortOrder: sortOrder
            })
        },
    }

}
</script>

<style scoped>

</style>
