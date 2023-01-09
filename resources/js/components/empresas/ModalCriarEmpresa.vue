<template>
    <BaseModal
        :aberta="config"
        @onClose="fecharModal"
        @onOpen="carregarFormulario"
    >
        <template #title>
            <h3>Criação de empresa</h3>
        </template>
        <template #body>
            <form @submit.prevent="submit">
                <div class="row">
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
                </div>
            </form>
        </template>
        <template #footer>
            <button class="btn btn-full btn-primary" @click.prevent="submit">
                <Loader v-if="loading" height="20px" width="20px"/>
                Cadastrar
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


export default {
    name: "ModalCriarEmpresa",
    setup() {
        const form = useForm({
            nome: '',
            email: '',
        });
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
                .post(`/empresas/cadastrar`, {
                    onSuccess: () => {
                        this.fecharModal();
                        this.$eventBus.$emit("ModalCriarEmpresa:reload");
                        this.loading = false;
                    },
                    onFinish: () => {
                        this.loading = false;
                    }
                });
        }
    },
    beforeUnmount() {
        this.$eventBus.$off("ModalCriarEmpresa:config");
    },
    created() {
        this.$eventBus.$on("ModalCriarEmpresa:config", (evento) => {
            this.config = evento;
        });
    },
}
</script>

<style scoped>

</style>
