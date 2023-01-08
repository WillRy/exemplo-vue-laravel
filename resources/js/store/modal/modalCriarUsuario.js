import {defineStore} from 'pinia'

export const modalCriarUsuarioStore = defineStore('modalCriarUsuario', {
    state: () => {
        return {
            open: false,
            payload: {},
            reload: {}
        }
    },
    actions: {
        abrir(dados = {}) {
            this.open = true;
            this.payload = dados;
        },
        fechar() {
            this.open = false;
        },
        onReload(payload = {}) {
            this.reload = payload
        }
    },
})
