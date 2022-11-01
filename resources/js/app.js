import "./bootstrap";

import {createApp, h} from "vue";
import {createInertiaApp} from "@inertiajs/inertia-vue3";
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';

import VueToast from 'vue-toast-notification';
import FloatingVue from 'floating-vue'

import outside from './directives/click-outside';

import Loader from "./components/base/Loader";

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(VueToast)
            .use(FloatingVue)
            .use(outside)
            .component('Loader', Loader)
            .mount(el);
    },
});
