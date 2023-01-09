<template>
    <BaseModal
        :aberta="config"
        @onClose="fecharModal"
        @onOpen="carregarFormulario"
    >
        <template #title>
            <h3>Exclusão de empresa</h3>
        </template>
        <template #body>
            <p>Deseja excluir esta empresa?</p>
        </template>
        <template #footer>
            <BaseButtonDanger @click.prevent="submit" :loading="loading">
                Excluir
            </BaseButtonDanger>
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
import BaseButtonPrimary from "../base/buttons/BaseButtonPrimary";
import BaseButtonTertiary from "../base/buttons/BaseButtonTertiary";
import BaseButtonDanger from "../base/buttons/BaseButtonDanger";


export default {
    name: "ModalExcluirEmpresa",
    setup() {
        const form = useForm({
            nome: '',
            email: '',
        });
        return {form};
    },
    components: {BaseButtonDanger, BaseButtonTertiary, BaseButtonPrimary, BaseModal, BaseInput},
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
                .post(`/empresas/excluir/${this.config.id}`, {
                    onSuccess: () => {
                        this.fecharModal();
                        this.$eventBus.$emit("ModalExcluirEmpresa:reload");
                        this.loading = false;
                    },
                    onFinish: () => {
                        this.loading = false;
                    }
                });
        }
    },
    beforeUnmount() {
        this.$eventBus.$off("ModalExcluirEmpresa:config");
    },
    created() {
        this.$eventBus.$on("ModalExcluirEmpresa:config", (evento) => {
            this.config = evento;
        });
    },
}
</script>

<style scoped>

</style>
