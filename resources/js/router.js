import { createRouter, createWebHistory } from "vue-router";
import Login from "./components/Login.vue";
import Register from "./components/Register.vue";
import Dashboard from "./components/Dashboard.vue";
import axios, { Axios } from "axios";

const routes = [
    { path: '/', component: Login , name: "Login" },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
    { path: '/dashboard', component: Dashboard, name: "dashboard", meta: { requiresAuth: true },}
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = getCookie("JWTtoken");

    if (to.meta.requiresAuth && !token) {
        next({ name: 'Login' }); // Redirect to login if not authenticated
    } else {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        axios.defaults.headers.common['Accept'] = 'application/json';
        next(); // Proceed to route
    }
});

// function Autenticated(){
//     const token = getCookie("JWTtoken");

//     axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
//     axios.defaults.headers.common['Accept'] = 'application/json';

//     if (to.meta.requiresAuth && !token) {
//         next({ name: 'Login' }); // Redirect to login if not authenticated
//     } else {
//         next(); // Proceed to route
//     }

// }

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

export default router;
