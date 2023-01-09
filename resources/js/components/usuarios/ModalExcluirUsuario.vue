<template>
    <BaseModal
        :aberta="modalExcluirUsuarioState.open"
        @onClose="fecharModal"
        @onOpen="carregarFormulario"
    >
        <template #title>
            <h3>Exclusão de usuário</h3>
        </template>
        <template #body>
            <p>Deseja excluir este usuário?</p>
        </template>
        <template #footer>
            <button class="btn btn-full btn-primary" @click.prevent="submit">
                <Loader v-if="loading" height="20px" width="20px"/>
                Excluir
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
import {modalExcluirUsuarioStore} from "../../store/usuarios/index";


export default {
    name: "ModalExcluirUsuario",
    setup() {
        const form = useForm({});

        const modalExcluirUsuarioState = modalExcluirUsuarioStore();

        return {form, modalExcluirUsuarioState};
    },
    components: {BaseModal, BaseInput},
    data() {
        return {
            config: false,
            loading: false,
        }
    },
    methods: {
        carregarFormulario() {

        },
        fecharModal() {
            this.modalExcluirUsuarioState.fechar();
            this.form.clearErrors();
            this.form.reset();
            this.$emit("onClose");
        },
        async submit() {
            this.loading = true;
            this.form
                .post(`/usuarios/excluir/${this.modalExcluirUsuarioState.payload.id}`, {
                    onSuccess: () => {
                        this.fecharModal();
                        this.modalExcluirUsuarioState.onReload();
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
