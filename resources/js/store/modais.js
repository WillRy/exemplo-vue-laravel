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
        abrirModalCriarUsuario(dados = {}) {
            this.open = true;
            this.payload = dados;
        },
        fecharModalCriarUsuario() {
            this.open = false;
        },
        onReload(payload = {}) {
            this.reload = payload
        }
    },
})

export const modalEditarUsuarioStore = defineStore('modalEditarUsuario', {
    state: () => {
        return {
            open: false,
            payload: {},
            reload: {}
        }
    },
    actions: {
        abrirModalEditarUsuario(dados = {}) {
            this.open = true;
            this.payload = dados;
        },
        fecharModalEditarUsuario() {
            this.open = false;
        },
        onReload(payload = {}) {
            this.reload = payload
        }
    },
})

export const modalExcluirUsuarioStore = defineStore('modalExcluirUsuarioStore', {
    state: () => {
        return {
            open: false,
            payload: {},
            reload: {}
        }
    },
    actions: {
        abrirModalExcluirUsuario(dados = {}) {
            this.open = true;
            this.payload = dados;
        },
        fecharModalExcluirUsuario() {
            this.open = false;
        },
        onReload(payload = {}) {
            this.reload = payload
        }
    },
})
