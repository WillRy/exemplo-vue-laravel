<template>
    <div class="layout">
        <Header/>
        <Sidebar2/>
        <div class="home-section">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import Header from "../components/dashboard/Header";
import Sidebar2 from "../components/dashboard/Sidebar2";

export default {
    name: "Dashboard",
    components: {Sidebar2, Header},
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

</style>
