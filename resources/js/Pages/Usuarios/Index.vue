<template>
    <div class="usuarios">
        <HeaderPage titulo="Usuários">
            <ButtonPrimary @click="abrirCriar">
                Criar
            </ButtonPrimary>
        </HeaderPage>
        <PageContent>
            <ContentTable>
                <template #header>
                    <form @submit.prevent="pesquisar">
                        <div class="row align-items-center">
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
                            <div class="col-md-auto">
                                <ButtonPrimary>
                                    <Loader width="20px" height="20px" v-if="loading"/>
                                    Pesquisar
                                </ButtonPrimary>
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
                            <TabelaColuna>{{ dado.id }}</TabelaColuna>
                            <TabelaColuna>{{ dado.nome }}</TabelaColuna>
                            <TabelaColuna>{{ dado.email }}</TabelaColuna>
                            <TabelaColuna>{{ $filters.data(dado.admissao) }}</TabelaColuna>
                            <TabelaColuna>{{ dado.empresa.nome }}</TabelaColuna>
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
import TabelaHeadSort from "../../components/base/tabela/TabelaHeadSort";
import Tabela from "../../components/base/tabela/Tabela";
import axios from "axios";
import TabelaColuna from "../../components/base/tabela/TabelaColuna";
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

export default {
    name: "Index",
    components: {
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
        TabelaColuna, Tabela, TabelaHeadSort, ContentTable, ContentBox, Box, PageContent, HeaderPage
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
