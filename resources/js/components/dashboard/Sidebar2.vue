<template>
    <div class="sidebar" :class="{open: open}">
        <div class="logo-details">
            <i class='bx bxl-c-plus-plus icon'></i>
            <div class="logo_name">ACL</div>
            <!--            <i class='bx bx-menu' id="btn" @click="toggle"></i>-->

            <div class="btn-menu">
                <img src="/img/menu-w.svg" class="white" alt="" @click="toggle" v-if="!open">
                <img src="/img/menu-b.svg" class="black" alt="" @click="toggle" v-if="!open">
                <img src="/img/arrow-left-w.svg" class="btn-menu white" alt="" @click="toggle" v-if="open">
                <img src="/img/arrow-left-b.svg" class="btn-menu black" alt="" @click="toggle" v-if="open">
            </div>
        </div>
        <ul class="nav-list">
            <li>
                <Link href="/">
                    <img src="/img/home-b.svg" alt="" class="black">
                    <img src="/img/home-w.svg" alt="" class="white">
                    <span class="links_name">Dashboard</span>
                </Link>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <Link href="/empresas">
                    <img src="/img/empresa-b.svg" alt="" class="black">
                    <img src="/img/empresa-w.svg" alt="" class="white">
                    <span class="links_name">Empresas</span>
                </Link>
                <span class="tooltip">Empresas</span>
            </li>
            <li>
                <Link href="/usuarios">
                    <img src="/img/usuarios-b.svg" alt="" class="black">
                    <img src="/img/usuarios-w.svg" alt="" class="white">
                    <span class="links_name">Usuários</span>
                </Link>
                <span class="tooltip">Usuários</span>
            </li>
        </ul>
    </div>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';

export default {
    name: "Sidebar2",
    components: {
        Link
    },
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

<style>
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100%;
    width: 64px;
    background: #11101D;
    padding: 0px 8px;
    z-index: 99;
    transition: all 0.5s ease;
}

.sidebar.open {
    width: 250px;
}

.sidebar .logo-details {
    height: 64px;
    display: flex;
    align-items: center;
    position: relative;
}

.sidebar .logo-details .icon {
    opacity: 0;
    transition: all 0.5s ease;
}

.sidebar .logo-details .logo_name {
    color: #fff;
    font-size: 20px;
    font-weight: 600;
    opacity: 0;
    transition: all 0.5s ease;
}

.sidebar.open .logo-details .icon,
.sidebar.open .logo-details .logo_name {
    opacity: 1;
}

.sidebar .logo-details .btn-menu {
    position: absolute;
    top: 50%;
    right: 50%;
    transform: translate(50%, -50%);
    font-size: 23px;
    text-align: center;
    cursor: pointer;
    transition: all 0.5s ease;
    width: 45px;
    border-radius: 12px;
    height: 45px;
    padding: 4px;
}

.btn-menu:hover {
    background: #fff;
}

.btn-menu:hover .white {
    display: none;
}

.btn-menu:hover .black {
    display: block;
}


.sidebar.open .logo-details .btn-menu {
    text-align: right;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
}

.sidebar i {
    color: #fff;
    height: 60px;
    min-width: 50px;
    font-size: 28px;
    text-align: center;
    line-height: 60px;
}

.sidebar .nav-list {
    margin-top: 20px;
    height: 100%;
}

.sidebar li {
    position: relative;
    margin: 8px 0;
    list-style: none;
}

.sidebar li .tooltip {
    position: absolute;
    top: -20px;
    left: calc(100% + 15px);
    z-index: 3;
    background: #fff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 15px;
    font-weight: 400;
    opacity: 0;
    white-space: nowrap;
    pointer-events: none;
    transition: 0s;
}

.sidebar li:hover .tooltip {
    opacity: 1;
    pointer-events: auto;
    transition: all 0.4s ease;
    top: 50%;
    transform: translateY(-50%);
}

.sidebar.open li .tooltip {
    display: none;
}

.sidebar input {
    font-size: 15px;
    color: #FFF;
    font-weight: 400;
    outline: none;
    height: 50px;
    width: 100%;
    width: 50px;
    border: none;
    border-radius: 12px;
    transition: all 0.5s ease;
    background: #1d1b31;
}

.sidebar.open input {
    padding: 0 20px 0 50px;
    width: 100%;
}


.sidebar li a {
    display: flex;
    height: 45px;
    /*width: 45px;*/
    border-radius: 12px;
    align-items: center;
    /*justify-content: center;*/
    text-decoration: none;
    transition: all 0.5s ease;
    background: #11101D;
    gap: 10px;
}

.sidebar.open li a {
    /*justify-content: inherit;*/
}

.sidebar.open li a {
    width: 100%;
}

.sidebar li a:hover {
    background: #FFF;
}

img.black {
    display: none;
}

.sidebar li a:hover img.white {
    display: none;
}

.sidebar li a:hover img.black {
    display: block;
}


.sidebar li a .links_name {
    color: #fff;
    font-size: 15px;
    font-weight: 400;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: 0.5s;
    /*position: absolute;*/
    /*display: none;*/
}

.sidebar.open li a .links_name {
    position: static;
    /*display: block;*/
}

.sidebar.open li a .links_name {
    opacity: 1;
    pointer-events: auto;
}

.sidebar li a:hover .links_name,
.sidebar li a:hover i {
    transition: all 0.5s ease;
    color: #11101D;
}

.sidebar li i {
    height: 42px;
    line-height: 42px;
    font-size: 18px;
    border-radius: 12px;
}


.sidebar li.profile {
    position: fixed;
    height: 60px;
    width: 64px;
    left: 0;
    bottom: -8px;
    padding: 10px 14px;
    background: #1d1b31;
    transition: all 0.5s ease;
    overflow: hidden;
}

.sidebar.open li.profile {
    width: 250px;
}

.sidebar li .profile-details {
    display: flex;
    align-items: center;
    flex-wrap: nowrap;
}

.sidebar li img {
    height: 32px;
    line-height: 32px;
    font-size: 18px;
    border-radius: 12px;
    margin-left: 7px;
}


.sidebar li.profile .name,
.sidebar li.profile .job {
    font-size: 15px;
    font-weight: 400;
    color: #fff;
    white-space: nowrap;
}

.sidebar li.profile .job {
    font-size: 12px;
}

.sidebar .profile #log_out {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    background: #1d1b31;
    width: 100%;
    height: 60px;
    line-height: 60px;
    border-radius: 0px;
    transition: all 0.5s ease;
}

.sidebar.open .profile #log_out {
    width: 50px;
    background: none;
}

.home-section {
    position: relative;
    background: #E4E9F7;
    min-height: 100vh;
    top: 0;
    left: 64px;
    width: calc(100% - 64px);
    transition: all 0.5s ease;
    z-index: var(--z-index-1);
    padding-top: 64px;
}

.sidebar.open ~ .home-section {
    left: 250px;
    width: calc(100% - 250px);
}

.home-section .text {
    display: inline-block;
    color: #11101d;
    font-size: 25px;
    font-weight: 500;
    margin: 18px
}

@media (max-width: 420px) {
    .sidebar li .tooltip {
        display: none;
    }
}

</style>
