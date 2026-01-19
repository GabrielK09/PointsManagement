import MainLayout from 'src/layouts/MainLayout.vue';
import Login from 'src/modules/auth/pages/Login.vue';
import HomePage from 'src/modules/points/pages/HomePage.vue';

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
    {
        path: '/points',
        component: MainLayout,
        children: [
            {
                path: 'home',
                name: 'home',
                component: HomePage
            }
        ]
    },

    // Always leave this as last one,
    // but you can also remove it
    {
        path: '/:catchAll(.*)*',
        component: () => import('src/modules/ErrorNotFound.vue'),
    },
];

export default routes;
