<template>
    <BaseModal
        :aberta="modalCriarUsuarioState.open"
        @onClose="fecharModal"
        @onOpen="carregarFormulario"
    >
        <template #title>
            <h3>Criação de usuário</h3>
        </template>
        <template #body>
            <form @submit.prevent="submit">
                <div class="row gap-xss">
                    <div class="col-12">
                        <BaseSelectAjax
                            label="Empresa *"
                            placeholder="Pesquise as empresas"
                            v-model="form.empresa_id"
                            track-by="id"
                            text-by="nome"
                            :options="resultadoPesquisaEmpresa"
                            @search-change="pesquisarEmpresa"
                            :clear="true"
                            noOptions="Pesquise as empresas"
                            :empty="false"
                            :remover="true"
                            :class="{error: form.errors.empresa_id}"
                            :error="form.errors.empresa_id"
                        >
                        </BaseSelectAjax>
                    </div>

                    <div class="col-12">
                        <BaseInput
                            v-model="form.nome"
                            :class="{error: form.errors.nome}"
                            :error="form.errors.nome"
                            label="Nome *"
                            placeholder="Nome"
                        />
                    </div>
                    <div class="col-12">
                        <BaseInput
                            v-model="form.email"
                            :class="{ error: form.errors.email }"
                            :error="form.errors.email"
                            label="E-mail *"
                            placeholder="E-mail"
                            type="email"
                        />
                    </div>
                    <div class="col-12">
                        <BaseInput
                            v-model="form.senha"
                            :class="{ error: form.errors.senha }"
                            :error="form.errors.senha"
                            label="Senha *"
                            placeholder="senha"
                            type="password"
                        />
                    </div>
                    <div class="col-12">
                        <BaseDate
                            v-model="form.admissao"
                            :class="{ error: form.errors.admissao }"
                            :error="form.errors.admissao"
                            label="Data de Admissao"
                            placeholder="Admissao"

                        />
                    </div>
                </div>
            </form>
        </template>
        <template #footer>
            <BaseButtonPrimary @click.prevent="submit" :loading="loading">
                Cadastrar
            </BaseButtonPrimary>
            <BaseButtonTertiary @click.prevent="fecharModal">
                Cancelar
            </BaseButtonTertiary>
        </template>
    </BaseModal>
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";
import BaseInput from "../base/form/BaseInput";
import BaseModal from "../base/modal/BaseModal";
import BaseSelectAjax from "../base/form/BaseSelectAjax";
import axios from "axios";
import BaseDate from "../base/form/BaseDate";
import {modalCriarUsuarioStore} from "../../store/usuarios/index";
import BaseButtonPrimary from "../base/buttons/BaseButtonPrimary";
import BaseButtonTertiary from "../base/buttons/BaseButtonTertiary";


export default {
    name: "ModalCriarUsuario",
    setup() {

        const form = useForm({
            nome: '',
            email: '',
            senha: '',
            empresa_id: null,
            admissao: null,
        });

        const modalCriarUsuarioState = modalCriarUsuarioStore();


        return {form, modalCriarUsuarioState};
    },
    components: {BaseButtonTertiary, BaseButtonPrimary, BaseDate, BaseSelectAjax, BaseModal, BaseInput},
    data() {
        return {
            config: false,
            loading: false,
            resultadoPesquisaEmpresa: []
        }
    },
    computed: {},
    methods: {

        pesquisarEmpresa(pesquisa) {
            axios.get(`/empresas/listar`, {params: {pesquisa: pesquisa}}).then((response) => {
                this.resultadoPesquisaEmpresa = response.data.data.data;
            });
        },
        carregarFormulario() {

        },
        fecharModal() {
            this.modalCriarUsuarioState.fechar()
            this.form.clearErrors();
            this.form.reset();
            this.$emit("onClose");
        },
        async submit() {

            this.loading = true;
            this.form
                .transform((data => {
                    return {
                        ...data,
                        empresa_id: data.empresa_id ? data.empresa_id.id : null
                    }
                }))
                .post(`/usuarios/cadastrar`, {
                    onSuccess: () => {
                        this.fecharModal();
                        this.modalCriarUsuarioState.onReload();
                        this.loading = false;
                    },
                    onFinish: () => {
                        this.loading = false;
                    }
                });
        }
    },
    beforeUnmount() {
    },
    created() {
    },
}
</script>

<style scoped>

</style>
