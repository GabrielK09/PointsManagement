import Login from 'src/modules/auth/pages/Login.vue';
import type { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
    {
        path: '/',
        component: () => import('src/layouts/MainLayout.vue'),
        children: [
            
        ],
    },
    {
        path: '/login',
        component: Login
    },

    // Always leave this as last one,
    // but you can also remove it
    {
        path: '/:catchAll(.*)*',
        component: () => import('src/modules/ErrorNotFound.vue'),
    },
];

export default routes;
