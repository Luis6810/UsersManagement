import './bootstrap';
import { createApp } from "vue";
import router from './router';
// import router from "./router/router";
// import { createApp } from 'vue/dist/vue.esm-bundler';
import vuetify from "./vuetify";
import app from "./layouts/app.vue";
import Register from "./components/Register.vue";
import Login from "./components/Login.vue";
import App from './layouts/app.vue';

// createApp(app).mount("#app");
const appli = createApp(App).use(vuetify)
                            .use(router);
                            // .component('register', Register)
                            // .component('login', Login);
// appli.component('register', Register);
// appli.component('Login', Login);
appli.mount("#app");

// createApp({
//     // template : app,
//     components: {
//         Register,
//         Login
//     },
// }).use(vuetify).mount('#app');

// createApp(app).use(vuetify).mount("#app");
