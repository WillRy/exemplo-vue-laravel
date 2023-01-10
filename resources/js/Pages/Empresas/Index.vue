<template>
    <div class="empresas">
        <HeaderPage titulo="Empresas">
            <BaseButtonPrimary @click="abrirCriar">
                Criar
            </BaseButtonPrimary>
        </HeaderPage>
        <PageContent>
            <ContentTable>
                <template #header>
                    <form @submit.prevent="pesquisar">
                        <div class="row align-items-center gap-sm">
                            <div class="col-md-4">
                                <BaseInput
                                    label="Pesquisa"
                                    name="pesquisa"
                                    v-model="form.pesquisa"
                                />
                            </div>
                            <div class="col-md-4">
                                <BaseButtonPrimary :loading="loading">
                                    Pesquisar
                                </BaseButtonPrimary>
                            </div>
                        </div>
                    </form>
                </template>
                <Tabela
                    :loading="loading"
                    :colunas="[
                        {
                            nome: 'id',
                            texto: 'ID'
                        },
                        {
                            nome: 'nome',
                            texto: 'nome'
                        },
                        {
                            nome: 'email',
                            texto: 'email'
                        },
                        {
                            nome: 'usuarios_count',
                            texto: 'qtd. usuários'
                        },
                    ]"
                    :dados="empresas && empresas.data"
                    :sort-name="sortName"
                    :sort-order="sortOrder"
                    @onSort="sortBy"
                    texto-empty="Não há dados"
                >
                    <template v-slot:colunas="{ dados }">
                        <tr v-for="(dado,index) in dados" :key="index">
                            <ColunaTabela>{{ dado.id }}</ColunaTabela>
                            <ColunaTabela>{{ dado.nome }}</ColunaTabela>
                            <ColunaTabela>{{ dado.email }}</ColunaTabela>
                            <ColunaTabela>{{ dado.usuarios_count }}</ColunaTabela>
                            <th class="coluna-acoes">
                                <DropdownAcoes :fundoClaro="true">
                                    <button @click="abrirEdicao(dado)">Editar</button>
                                    <button @click="abrirExclusao(dado)">Excluir</button>
                                </DropdownAcoes>
                            </th>
                        </tr>
                    </template>
                </Tabela>
                <template #footer>
                    <PaginacaoSemRouter
                        :exibir-total="true"
                        v-if="empresas"
                        :pagina-atual="empresas.current_page"
                        :total="empresas.total"
                        :porPagina="empresas.per_page"
                        @onChange="updatePagina($event)"
                    />
                </template>
            </ContentTable>
        </PageContent>
        <ModalCriarEmpresa/>
        <ModalEditarEmpresa/>
        <ModalExcluirEmpresa/>
    </div>
</template>

<script>

import Dashboard from "../../Layouts/Dashboard";
import HeaderPage from "../../components/base/pages/HeaderPage";
import PageContent from "../../components/base/pages/PageContent";
import Box from "../../components/base/pages/ContentBox";
import ContentBox from "../../components/base/pages/ContentBox";
import ContentTable from "../../components/base/pages/ContentTable";
import HeadSort from "../../components/base/tabela/HeadSort";
import Tabela from "../../components/base/tabela/Tabela";
import axios from "axios";
import ColunaTabela from "../../components/base/tabela/ColunaTabela";
import PaginacaoSemRouter from "../../components/base/paginacao/PaginacaoSemRouter";
import BaseInput from "../../components/base/form/BaseInput";
import {useForm} from "@inertiajs/inertia-vue3";
import ButtonPrimary from "../../components/base/btn/ButtonPrimary";
import DropdownAcoes from "../../components/base/dropdown/DropdownAcoes";
import ModalCriarEmpresa from "../../components/empresas/ModalCriarEmpresa";
import ModalEditarEmpresa from "../../components/empresas/ModalEditarEmpresa";
import ModalExcluirEmpresa from "../../components/empresas/ModalExcluirEmpresa";
import BaseButtonPrimary from "../../components/base/buttons/BaseButtonPrimary";

export default {
    name: "Index",
    components: {
        BaseButtonPrimary,
        ModalExcluirEmpresa,
        ModalEditarEmpresa,
        ModalCriarEmpresa,
        DropdownAcoes,
        ButtonPrimary,
        BaseInput,
        PaginacaoSemRouter,
        ColunaTabela, Tabela, HeadSort, ContentTable, ContentBox, Box, PageContent, HeaderPage
    },
    layout: Dashboard,
    setup() {
        const form = useForm({
            pesquisa: ''
        });
        return {form};
    },
    data() {
        return {
            loading: false,
            sortName: 'id',
            sortOrder: 'desc',
            page: 1,
            empresas: null
        }
    },
    methods: {
        abrirCriar() {
            this.$eventBus.$emit("ModalCriarEmpresa:config", {});
        },
        abrirEdicao(empresa) {
            this.$eventBus.$emit("ModalEditarEmpresa:config", empresa);
        },
        abrirExclusao(empresa) {
            this.$eventBus.$emit("ModalExcluirEmpresa:config", empresa);
        },
        sortBy({sortName, sortOrder}) {
            console.log(sortName, sortOrder)
            this.sortName = sortName;
            this.sortOrder = sortOrder;
            this.buscarDados();
        },
        updatePagina(pagina) {
            this.page = pagina;
            this.buscarDados()
        },
        pesquisar() {
            this.page = 1;
            this.buscarDados()
        },
        buscarDados() {
            this.loading = true;
            axios.get('/empresas/listar', {
                params: {
                    ...(this.form.pesquisa ? {pesquisa: this.form.pesquisa} : {}),
                    ...(this.page ? {page: this.page} : {}),
                    sortOrder: this.sortOrder,
                    sortName: this.sortName,
                }
            }).then((r) => {
                if (!r.data.success) return;

                this.empresas = r.data.data;
            }).finally(() => {
                this.loading = false;
            })
        }
    },
    beforeUnmount() {
        this.$eventBus.$off('ModalCriarEmpresa:reload')
        this.$eventBus.$off('ModalEditarEmpresa:reload')
        this.$eventBus.$off('ModalExcluirEmpresa:reload')
    },
    created() {
        this.$eventBus.$on('ModalCriarEmpresa:reload', (e) => {
            this.buscarDados();
        })
        this.$eventBus.$on('ModalEditarEmpresa:reload', (e) => {
            this.buscarDados();
        })
        this.$eventBus.$on('ModalExcluirEmpresa:reload', (e) => {
            this.buscarDados();
        })
        this.buscarDados();
    }
}
</script>

<style scoped>

</style>
