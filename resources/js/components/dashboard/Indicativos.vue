<template>
    <div>
        <HeaderPage titulo="Dashboard"></HeaderPage>
        <PageContent>
            <div class="indicativos">
                <Loader width="120px" height="120px" :cor-principal="true" v-if="loadingDados"></Loader>
                <div class="flex flex-wrap gap-s" v-else>
                    <div
                        class="md:w-2/12 w-full"
                    >
                        <div class="indicativo">
                            <img src="/img/empresa-b.svg" alt="Empresas">
                            Empresas: {{ indicativos.qtd_empresas }}
                        </div>
                    </div>
                    <div
                        class="md:w-2/12 w-full"
                    >
                        <div class="indicativo">
                            <img src="/img/usuarios-b.svg" alt="Usuarios">
                            Usuários: {{ indicativos.qtd_usuarios }}
                        </div>
                    </div>
                </div>
            </div>
        </PageContent>
    </div>

</template>

<script>
import Loader from "../base/Loader";
import axios from "axios";
import PageContent from "../base/pages/PageContent";
import HeaderPage from "../base/pages/HeaderPage";

export default {
    name: "Indicativos",
    components: {HeaderPage, PageContent, Loader},
    data() {
        return {
            loadingDados: false,
            indicativos: null
        }
    },
    methods: {
        buscarDados() {
            this.loadingDados = true;
            axios.get('/dashboard/indicativos').then((r) => {

                this.indicativos = r.data.data;
            }).finally(() => {
                this.loadingDados = false;
            })
        }
    },
    created() {
        this.buscarDados();
    }
}
</script>

<style scoped>
.indicativo {
    background: #fff;
    border-radius: var(--radius-principal);
    padding: 20px;

    display: flex;
    align-items: center;
    gap: 10px;
}

.indicativo img {
    width: 42px;
}
</style>
