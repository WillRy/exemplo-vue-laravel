<template>
    <BaseModal
        :aberta="config"
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
import BaseModal from "../base/modal/BaseModel";


export default {
    name: "ModalExcluirUsuario",
    setup() {
        const form = useForm({});
        return {form};
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
            this.config = null;
            this.form.clearErrors();
            this.form.reset();
            this.$emit("onClose");
        },
        async submit() {
            this.loading = true;
            this.form
                .post(`/usuarios/excluir/${this.config.id}`, {
                    onSuccess: () => {
                        this.fecharModal();
                        this.$eventBus.$emit("ModalExcluirUsuario:reload");
                        this.loading = false;
                    },
                    onFinish: () => {
                        this.loading = false;
                    }
                });
        }
    },
    beforeUnmount() {
        this.$eventBus.$off("ModalExcluirUsuario:config");
    },
    created() {
        this.$eventBus.$on("ModalExcluirUsuario:config", (evento) => {
            this.config = evento;
        });
    },
}
</script>

<style scoped>

</style>
