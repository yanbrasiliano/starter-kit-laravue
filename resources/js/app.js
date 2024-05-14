import { createApp } from 'vue';
import App from '@/App.vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import { Quasar, Notify, Loading, Dialog, Dark, Platform, LocalStorage } from 'quasar';
import 'quasar/src/css/index.sass';
import langPTBR from 'quasar/lang/pt-BR';
import router from '@/routes';
import materialIcons from 'quasar/icon-set/material-symbols-outlined.mjs';

Quasar.lang.set(Quasar.lang.ptBR);
Quasar.iconSet.set(materialIcons);
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);
const app = createApp(App);

app.use(pinia);
app.use(router);

app.use(Quasar, {
  lang: langPTBR,
  iconSet: materialIcons,
  config: {},
  plugins: {
    Notify,
    Loading,
    Dialog,
    Dark,
    Platform,
    LocalStorage,
  },
});

app.mount('#app');
