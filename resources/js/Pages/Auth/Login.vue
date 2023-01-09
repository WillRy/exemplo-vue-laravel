<template>
    <div class="login">
        <h3 class="titulo">Login</h3>
        <form @submit.prevent="submit">
            <BaseInput
                label="E-mail"
                placeholder="Informe seu e-mail"
                name="email"
                v-model="form.email"
                :error="form.errors.email"
                :class="{error: form.errors.email}"
            />

            <BaseInput
                label="Senha"
                placeholder="Informe sua senha"
                name="senha"
                v-model="form.senha"
                :error="form.errors.senha"
                :class="{error: form.errors.senha}"
                type="password"
            />

            <BaseButtonPrimary :full="true" :loading="loading" type="submit">
                Entrar
            </BaseButtonPrimary>
<!--            <LinkPrimary :full="true" href="/cadastro">Cadastrar-se</LinkPrimary>-->
        </form>
    </div>
</template>

<script>
import Auth from "../../Layouts/Auth";
import BaseInput from "../../components/base/form/BaseInput";
import ButtonPrimary from "../../components/base/btn/ButtonPrimary";
import {useForm} from "@inertiajs/inertia-vue3";
import LinkPrimary from "../../components/base/btn/LinkPrimary";
import BaseButtonPrimary from "../../components/base/buttons/BaseButtonPrimary";

export default {
    name: "Login",
    components: {BaseButtonPrimary, LinkPrimary, ButtonPrimary, BaseInput},
    layout: Auth,
    setup() {
        const form = useForm({
            email: '',
            senha: ''
        });
        return {form};
    },
    data() {
        return {
            loading: false
        }
    },
    methods: {
        submit() {
            this.form.post('/logar', {
                onStart: () => {
                    this.loading = true;
                },
                onSuccess: (page) => {

                },
                onFinish: () => {
                    this.loading = false;
                }
            })
        }
    }
}
</script>

<style scoped>
.login {
    width: 100%;
    max-width: 420px;
    padding: 20px;

    border-radius: 8px;

    border: 1px solid #f1f1f1;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;

    background: #fff;
}

.titulo {
    text-align: center;
    margin-bottom: 24px;
}
</style>
