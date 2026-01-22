import { boot } from 'quasar/wrappers';
import axios, { type AxiosInstance } from 'axios';
import { LocalStorage } from 'quasar';

axios.defaults.withCredentials = false;
declare module 'vue' {
    interface ComponentCustomProperties {
        $axios: AxiosInstance;
        $api: AxiosInstance;
        $apiService: AxiosInstance;
    }
}

// Be careful when using SSR for cross-request state pollution
// due to creating a Singleton instance here;
// If any client changes this (global) instance, it might be a
// good idea to move this instance creation inside of the
// "export default () => {}" function below (which runs individually
// for each client)

const api = axios.create({
    baseURL: process.env.API_URL,
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'
    }
});

export default boot(({ app, router }) => {
    api.interceptors.request.use(
        (config) => {

            const token = LocalStorage.getItem('auth_token');

            const isPublicRoutes = [
                '/auth/login',
                '/auth/register',
            ];

            const isPublic = isPublicRoutes.some(route => config.url.includes(route));

            if(!token && !isPublic)
            {
                LocalStorage.remove('user_id');
                LocalStorage.remove('auth_token');

                router.replace({ path: '/login' });

                return Promise.reject("Usuário não autenticado");
            };

            if (token) {
                config.headers.Authorization = `Bearer ${token}`;
            };

            return config;
        },
        (error) => {
            console.error('axios.ts - error - line 59', error);

            return Promise.reject(error);
        }
    );

    api.interceptors.response.use(
        (response) => response,
        (error) => {
            console.error('axios.ts - error - line 68', error);

            if(error.response && error.response.status === 401) {
                router.replace({
                    path: '/login'

                });
            };

            if(error.response && error.response.status === 500) {
                app.config.globalProperties.$q.notify({
                    message: 'Erro interno',
                    type: 'negative',
                    position: 'top'
                });
            };

            return Promise.reject(error);
        }
    )

    app.config.globalProperties.$axios = axios;
    // ^ ^ ^ this will allow you to use this.$axios (for Vue Options API form)
    //       so you won't necessarily have to import axios in each vue file

    app.config.globalProperties.$api = api;
    // ^ ^ ^ this will allow you to use this.$api (for Vue Options API form)
    //       so you can easily perform requests against your app's API
});

export { api };
