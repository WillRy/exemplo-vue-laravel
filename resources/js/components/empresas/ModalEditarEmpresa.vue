<template>
    <BaseModal
        :aberta="config"
        @onClose="fecharModal"
        @onOpen="carregarFormulario"
    >
        <template #title>
            <h3>Edição de empresa</h3>
        </template>
        <template #body>
            <Loader width="60px" height="60px" :cor-principal="true" v-if="loadingDados"></Loader>
            <form @submit.prevent="submit" v-else>
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
import BaseModal from "../base/modal/BaseModel";
import Loader from "../base/Loader";
import axios from "axios";


export default {
    name: "ModalEditarEmpresa",
    setup() {
        const form = useForm({
            nome: '',
            email: '',
        });
        return {form};
    },
    components: {Loader, BaseModal, BaseInput},
    data() {
        return {
            config: false,
            loading: false,
            loadingDados: false
        }
    },
    methods: {
        carregarFormulario() {
            this.loadingDados = true;
            axios.get(`/empresas/detalhes/${this.config.id}`).then((r) => {
                Object.assign(this.form, r.data.data);
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
            this.config = null;
            this.form.clearErrors();
            this.form.reset();
            this.$emit("onClose");
        },
        async submit() {
            this.loading = true;
            this.form
                .post(`/empresas/editar/${this.config.id}`, {
                    onSuccess: () => {
                        this.fecharModal();
                        this.$eventBus.$emit("ModalEditarEmpresa:reload");
                        this.loading = false;
                    },
                    onFinish: () => {
                        this.loading = false;
                    }
                });
        }
    },
    beforeUnmount() {
        this.$eventBus.$off("ModalEditarEmpresa:config");
    },
    created() {
        this.$eventBus.$on("ModalEditarEmpresa:config", (evento) => {
            this.config = evento;
        });
    },
}
</script>

<style scoped>

</style>
