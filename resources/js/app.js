
import { createApp } from 'vue';
import ToastPlugin from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-default.css';
import { createPinia } from 'pinia'

import App from './vue/App.vue';
import router from './vue/router';

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(ToastPlugin, {
    transition: "Vue-Toastification__bounce",
    newestOnTop: true,
    maxToasts: 20,
    timeout: 2000,
    showCloseButtonOnHover: true,
    pauseOnFocusLoss: false
});

app.mount('#app');
