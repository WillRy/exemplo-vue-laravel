import {defineStore} from 'pinia'

export const modalExcluirUsuarioStore = defineStore('modalExcluirUsuarioStore', {
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
