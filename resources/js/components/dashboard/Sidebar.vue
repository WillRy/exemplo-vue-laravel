<template>
    <div class="sidebar" :class="{open: open}">
        <div class="header">
            <img class="btn-toggle" @click="toggle" src="/img/menu.svg"/>
            <div class="logo">
                Sistema de ACL
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Sidebar",
    data() {
        return {
            open: false
        }
    },
    methods: {
        toggle() {
            this.open = !this.open;
        }
    }
}
</script>

<style scoped>
.sidebar {
    background-color: #fff;
    height: auto;
    text-align: center;
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    box-shadow: 0 3px 6px #00000029;
    overflow-x: hidden;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    transition: width .2s;
    z-index: var(--z-index-2);
    width: 64px;
}

.sidebar.open {
    width: 220px;
}


.header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 8px;
    height: 64px;
    width: 100%;
}

.logo {
    flex-shrink: 0;
    color: var(--cor-principal);
    display: none;
    transform: translate(9999px);
    opacity: 0;
}

.open .logo {
    display: flex;
    transform: translate(0px);
    opacity: 1;
}

.btn-toggle {
    width: 24px;
    height: 24px;
}
</style>
