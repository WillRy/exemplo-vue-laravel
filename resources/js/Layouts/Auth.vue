<template>
    <div class="layout">
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: "Auth",
    watch: {
        "$page.props.flash.success": {
            deep: true,
            handler(valor) {
                this.exibirSuccess(valor);
            }
        },
        "$page.props.flash.error": {
            deep: true,
            handler(valor) {
                if (!valor) {
                    return;
                }

                this.$toast.open({
                    message: valor,
                    type: "error",
                });
            }
        }
    },
    methods: {
        exibirSuccess(valor) {
            if (!valor) {
                return;
            }

            this.$toast.open({
                message: valor,
                type: "success",
            });
        },
        exibirError(valor) {
            if (!valor) {
                return;
            }

            this.$toast.open({
                message: valor,
                type: "error",
            });
        },
    },
    created() {
        if (this.$page.props.flash.success) {
            this.exibirSuccess(this.$page.props.flash.success);
        }
        if (this.$page.props.flash.error) {
            this.exibirError(this.$page.props.flash.error);
        }
    }
}
</script>

<style scoped>
.layout {
    display: flex;
    align-items: center;
    justify-content: center;

    height: 100vh;
    width: 100vw;

    background-color: var(--cor-principal);
    /*background: url("/img/auth-bg.jpg") center center no-repeat;*/
    background-size: cover;
}
</style>
