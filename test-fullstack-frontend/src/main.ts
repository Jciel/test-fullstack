import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import router from "./router"
import { createPinia } from "pinia";

import "@mdi/font/css/materialdesignicons.css";
import "@fortawesome/fontawesome-free/css/all.css";

import { aliases, mdi } from "vuetify/iconsets/mdi";
import { fa } from "vuetify/iconsets/fa";

const vuetify = createVuetify({
    icons: {
        defaultSet: "mdi",
        aliases,
        sets: {
            mdi,
            fa,
        },
    },
    components,
    directives,
});

createApp(App)
    .use(router)
    .use(vuetify)
    .use(createPinia())
    .mount('#app')
