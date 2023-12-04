import { createRouter, createWebHistory } from 'vue-router';
import utils from '../utils';
import { useTokenStore, useUserDetailsStore } from '../store';

import Home from '../pages/Home.vue';
import Login from '../pages/Login.vue';
import Register from '../pages/Register.vue';

const routes = [
    {
        path: '/',
        component: Home,
        name: 'home',
        meta: {
            requiresAuth: true,
        }
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    {
        path: '/register',
        component: Register,
        name: 'register'
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});



router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {
        const tokenStore = useTokenStore();
        const userDetailsStore = useUserDetailsStore();
        let token = tokenStore.getAPiToken();

        if (token) {
            try {
                const response = await utils.validateToken(token);
                userDetailsStore.setUserDetails(response.data.user);
                next();
            } catch (err) {
                console.log(err);
                tokenStore.removeApiToken();
                next({ name: 'login' });
            }
        } else {
            next({ name: 'login' });
        }
    } else {
        next();
    }
});

export default router;
