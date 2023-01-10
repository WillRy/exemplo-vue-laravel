<template>
    <div class="usuarios text-primary-900">
        <HeaderPage titulo="Usuários">
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
                                <BaseSelectAjax
                                    label="Empresa"
                                    placeholder="Pesquise as empresas"
                                    v-model="form.empresa_id"
                                    track-by="id"
                                    text-by="nome"
                                    :options="resultadoPesquisaEmpresa"
                                    @search-change="pesquisarEmpresa"
                                    noOptions="Pesquise as empresas"
                                    :empty="true"
                                    :remover="true"
                                >
                                </BaseSelectAjax>
                            </div>
                            <div class="col-auto">
                                <BaseButtonPrimary :loading="loading">
                                    Pesquisar
                                </BaseButtonPrimary>
                            </div>
                            <!--                            <div class="col-md-auto">-->
                            <!--                                <BaseButtonAction :loading="loading">-->
                            <!--                                    Pesquisar-->
                            <!--                                </BaseButtonAction>-->
                            <!--                            </div>-->
                            <!--                            <div class="col-md-auto">-->
                            <!--                                <BaseButtonDanger :loading="loading">-->
                            <!--                                    Pesquisar-->
                            <!--                                </BaseButtonDanger>-->
                            <!--                            </div>-->
                            <!--                            <div class="col-md-auto">-->
                            <!--                                <base-button-secondary :loading="loading">-->
                            <!--                                    Pesquisar-->
                            <!--                                </base-button-secondary>-->
                            <!--                            </div>-->
                            <!--                            <div class="col-md-auto">-->
                            <!--                                <BaseButtonSuccess :loading="loading">-->
                            <!--                                    Pesquisar-->
                            <!--                                </BaseButtonSuccess>-->
                            <!--                            </div>-->
                            <!--                            <div class="col-md-auto">-->
                            <!--                                <BaseButtonWarning :loading="loading">-->
                            <!--                                    Pesquisar-->
                            <!--                                </BaseButtonWarning>-->
                            <!--                            </div>-->
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
                            nome: 'admissao',
                            texto: 'Data de Admissão'
                        },
                        {
                            nome: 'empresa.nome',
                            texto: 'Empresa'
                        },
                    ]"
                    :dados="usuarios && usuarios.data"
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
                            <ColunaTabela>{{ $filters.data(dado.admissao) }}</ColunaTabela>
                            <ColunaTabela>{{ dado.empresa.nome }}</ColunaTabela>
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
                        v-if="usuarios"
                        :pagina-atual="usuarios.current_page"
                        :total="usuarios.total"
                        :porPagina="usuarios.per_page"
                        @onChange="updatePagina($event)"
                    />
                </template>
            </ContentTable>
        </PageContent>
        <ModalCriarUsuario/>
        <ModalEditarUsuario/>
        <ModalExcluirUsuario/>
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
import ModalCriarUsuario from "../../components/usuarios/ModalCriarUsuario";
import ModalEditarUsuario from "../../components/usuarios/ModalEditarUsuario";
import ModalExcluirUsuario from "../../components/usuarios/ModalExcluirUsuario";
import BaseSelectAjax from "../../components/base/form/BaseSelectAjax";
import BaseCheckbox from "../../components/base/form/BaseCheckbox";
import BaseCheckboxMultiple from "../../components/base/form/BaseCheckboxMultiple";
import {modalCriarUsuarioStore, modalEditarUsuarioStore, modalExcluirUsuarioStore} from '../../store/usuarios/index'
import BaseButtonPrimary from "../../components/base/buttons/BaseButtonPrimary";
import BaseButtonAction from "../../components/base/buttons/BaseButtonAction";
import BaseButtonDanger from "../../components/base/buttons/BaseButtonDanger";
import BaseButtonSecondary from "../../components/base/buttons/BaseButtonSecondary";
import BaseButtonSuccess from "../../components/base/buttons/BaseButtonSuccess";
import BaseButtonWarning from "../../components/base/buttons/BaseButtonWarning";

export default {
    name: "Index",
    components: {
        BaseButtonWarning,
        BaseButtonSuccess,
        BaseButtonSecondary,
        BaseButtonDanger,
        BaseButtonAction,
        BaseButtonPrimary,
        BaseCheckboxMultiple,
        BaseCheckbox,
        BaseSelectAjax,
        ModalExcluirUsuario,
        ModalEditarUsuario,
        ModalCriarUsuario,
        DropdownAcoes,
        ButtonPrimary,
        BaseInput,
        PaginacaoSemRouter,
        ColunaTabela, Tabela, HeadSort, ContentTable, ContentBox, Box, PageContent, HeaderPage
    },
    layout: Dashboard,
    setup() {
        const form = useForm({
            pesquisa: '',
            empresa_id: null,
            ativo: []
        });

        const modalCriarUsuarioState = modalCriarUsuarioStore();
        const modalEditarUsuarioState = modalEditarUsuarioStore();
        const modalExcluirUsuarioState = modalExcluirUsuarioStore();

        return {form, modalCriarUsuarioState, modalEditarUsuarioState, modalExcluirUsuarioState};
    },
    watch: {
        'modalCriarUsuarioState.reload': {
            handler() {
                this.buscarDados();
            }
        },
        'modalEditarUsuarioState.reload': {
            handler() {
                this.buscarDados();
            }
        },
        'modalExcluirUsuarioState.reload': {
            handler() {
                this.buscarDados();
            }
        },
    },
    data() {
        return {
            loading: false,
            sortName: 'id',
            sortOrder: 'desc',
            page: 1,
            usuarios: null,
            resultadoPesquisaEmpresa: []
        }
    },
    methods: {
        pesquisarEmpresa(pesquisa) {
            axios.get(`/empresas/listar`, {params: {pesquisa: pesquisa}}).then((response) => {
                this.resultadoPesquisaEmpresa = response.data.data.data;
            });
        },
        abrirCriar() {
            this.modalCriarUsuarioState.abrir();
        },
        abrirEdicao(usuario) {
            this.modalEditarUsuarioState.abrir(usuario);
        },
        abrirExclusao(usuario) {
            this.modalExcluirUsuarioState.abrir(usuario);
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
            axios.get('/usuarios/listar', {
                params: {
                    ...(this.form.pesquisa ? {pesquisa: this.form.pesquisa} : {}),
                    ...(this.form.empresa_id ? {empresa_id: this.form.empresa_id.id} : {}),
                    ...(this.page ? {page: this.page} : {}),
                    sortOrder: this.sortOrder,
                    sortName: this.sortName,
                }
            }).then((r) => {
                if (!r.data.success) return;

                this.usuarios = r.data.data;
            }).finally(() => {
                this.loading = false;
            })
        }
    },
    beforeUnmount() {

    },
    created() {
        this.buscarDados();
    }
}
</script>

<style scoped>

</style>
