<template>
    <BaseModal
        :aberta="modalEditarUsuarioState.open"
        @onClose="fecharModal"
        @onOpen="carregarFormulario"
    >
        <template #title>
            <h3>Edição de usuario</h3>
        </template>
        <template #body>
            <Loader width="60px" height="60px" :cor-principal="true" v-if="loadingDados"></Loader>
            <form @submit.prevent="submit" v-else>
                <div class="row">
                    <div class="col-md-12">
                        <BaseSelect
                            label="Empresa *"
                            placeholder="Pesquise as empresas"
                            v-model="form.empresa_id"
                            track-by="id"
                            text-by="nome"
                            :options="empresas"
                            :disabled="true"
                        >
                        </BaseSelect>
                    </div>

                    <div class="col-md-12">
                        <BaseInput
                            v-model="form.nome"
                            :class="{error: form.errors.nome}"
                            :error="form.errors.nome"
                            label="Nome *"
                            placeholder="Nome"
                        />
                    </div>
                    <div class="col-md-12">
                        <BaseInput
                            v-model="form.email"
                            :class="{ error: form.errors.email }"
                            :error="form.errors.email"
                            label="E-mail *"
                            placeholder="E-mail"
                            type="email"
                        />
                    </div>
                    <div class="col-md-12">
                        <BaseInput
                            v-model="form.senha"
                            :class="{ error: form.errors.senha }"
                            :error="form.errors.senha"
                            label="Senha"
                            placeholder="Senha"
                            type="password"
                        />
                    </div>
                    <div class="col-md-12">
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
            <button class="btn btn-full btn-primary" @click.prevent="submit">
                <Loader v-if="loading" height="20px" width="20px"/>
                Editar
            </button>
            <button class="btn btn-full btn-secondary" @click.prevent="fecharModal">
                Cancelar
            </button>
        </template>
    </BaseModal>
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";
import BaseInput from "../base/form/BaseInput";
import BaseModal from "../base/modal/BaseModal";
import Loader from "../base/Loader";
import axios from "axios";
import BaseSelectAjax from "../base/form/BaseSelectAjax";
import BaseSelect from "../base/form/BaseSelect";
import BaseDate from "../base/form/BaseDate";
import {modalEditarUsuarioStore} from "../../store/usuarios/index";


export default {
    name: "ModalEditarUsuario",
    setup() {
        const form = useForm({
            nome: '',
            email: '',
            senha: '',
            empresa_id: '',
            admissao: '',
        });

        const modalEditarUsuarioState = modalEditarUsuarioStore();

        return {form, modalEditarUsuarioState};
    },
    components: {BaseDate, BaseSelect, BaseSelectAjax, Loader, BaseModal, BaseInput},
    data() {
        return {
            config: false,
            loading: false,
            loadingDados: false,
            empresas: []
        }
    },
    methods: {
        carregarFormulario() {
            this.loadingDados = true;
            axios.get(`/usuarios/detalhes/${this.modalEditarUsuarioState.payload.id}`).then((r) => {
                Object.assign(this.form, r.data.data);
                this.form.empresa_id = r.data.data.empresa;
                this.empresas.push(this.form.empresa_id);
            }).catch((e) => {
                this.$toast.open({
                    type: 'error',
                    message: 'Não foi possível exibir os dados'
                });
                this.fecharModal();
            }).finally(() => {
                this.loadingDados = false;
            })
        },
        fecharModal() {
            this.modalEditarUsuarioState.fechar();
            this.form.clearErrors();
            this.form.reset();
            this.$emit("onClose");
        },
        async submit() {
            this.loading = true;
            this.form
                .post(`/usuarios/editar/${this.modalEditarUsuarioState.payload.id}`, {
                    onSuccess: () => {
                        this.fecharModal();
                        this.modalEditarUsuarioState.onReload();
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
