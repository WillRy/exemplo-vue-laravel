import "./bootstrap";

import {createApp, h} from "vue";
import {createInertiaApp} from "@inertiajs/inertia-vue3";
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';

import VueToast from 'vue-toast-notification';
import FloatingVue from 'floating-vue'
import {DatePicker} from 'v-calendar';

import outside from './directives/click-outside';

import Loader from "./components/base/Loader";

import {filters, EventBus} from './plugins';


import { createPinia } from 'pinia'
const pinia = createPinia()

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(pinia)
            .use(plugin)
            .use(VueToast)
            .use(FloatingVue)
            .use(outside)
            .use(filters)
            .use(EventBus)
            .component('DatePicker', DatePicker)
            .component('Loader', Loader)
            .mount(el);
    },
});
