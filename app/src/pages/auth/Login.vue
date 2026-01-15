<template>
    <main class="p-12">
        <div 
            class="text-2xl login-form" 
        >
            <article class="article-login-form">
                <q-form
                    @submit="login"
                    class="q-gutter-md mt-4"
                >
                    <h2 class="text-center">
                        Bem-vindo(a) de volta!
                    </h2>
                    <div class="flex justify-center">
                        <q-input 
                            v-model="auth.email" 
                            type="text" 
                            label=""
                            stack-label
                            outlined
                            color="grey"
                            class="w-[120%] mb-4 rounded-md"
                            :rules="[checkMail]"
                            hide-bottom-space
                            
                        >
                            <template v-slot:label>
                                <div class="border-b">E-mail <span class="text-red-500 text-xs relative bottom-1">*</span></div>
                            </template>

                            <template v-slot:prepend>
                                <div class="mt-2 ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" />
                                    </svg>

                                </div>
                            </template>
                        </q-input>

                        <q-input 
                            v-model="auth.password" 
                            :type="show ? 'text' : 'password'" 
                            stack-label
                            label-slot
                            borderless
                            color="grey"
                            label="Nome"
                            class="w-[120%] mb-4 border rounded-md"
                            required
                        >
                            <template v-slot:label>
                                <div class="border-b">Senha <span class="text-red-500 text-xs relative bottom-1">*</span></div>
                            </template>

                            <template v-slot:prepend>
                                <div class="flex mt-2 ml-4">
                                    <ShowPassword
                                        @show="show = $event"
                                    />
                                    
                                </div>
                            </template>
                            
                        </q-input>

                    </div>        
                    
                    <div class="w-40 ml-auto mr-auto">
                        <q-btn label="Entrar" type="submit" class="w-full" color="primary"/>
                        
                    </div>
                    <span   
                        class="text-xs flex mt-2 justify-center"
                    >
                        <router-link to="/auth/register">Ainda não possui uma conta?</router-link>
                        
                    </span>
                </q-form>
            </article>
        </div>
    </main>
</template>

<script setup lang="ts">
    import { LocalStorage, useQuasar } from 'quasar';
    import { api } from 'src/boot/axios';
    import { onMounted, ref } from 'vue';
    import { useRouter } from 'vue-router';
    import ShowPassword from 'src/components/ShowPassword/ShowPassword.vue';

    interface AuthData {
        email: string,
        password: string
    };

    const $q = useQuasar();
    const router = useRouter();

    const auth = ref<AuthData>({
        email: '',
        password: ''
        
    });

    let show = ref<boolean>(false);

    const login = async () => {
        $q.notify({
            color: 'green',
            message: 'Validando dados de login ... ',
            position: 'top',
            timeout: 1200

        });

        const payload: AuthData = {
            email: auth.value.email,
            password: auth.value.password
        };

        const res = await api.post('/auth/login', payload, {
            headers: {
                Accept: 'application/json'
            }
        });

        const data = res.data;
        
        if(data.success) 
        { 
            $q.notify({
                color: 'green',
                message: 'Login bem sucedido!',
                position: 'top',
                timeout: 1200

            });

            LocalStorage.set("authToken", data.token);
            LocalStorage.set("isAttendant", data.isAttendant);
            LocalStorage.set("siteName", data.siteName);
            LocalStorage.set("ownerCode", data.ownerCode);
            LocalStorage.set("lastCheck", 0);

            router.replace({ path: `/admin/${data.siteName}/dashboard` });
            
        } else {
            $q.notify({
                color: 'red',
                message: data.message,
                position: 'top',
                timeout: 1200

            });

            if(data.route)
            {
                router.replace({ path: data.route });
            };
        };
    };

    const checkMail = () => {
        if(!auth.value.email.trim().includes('@')) return 'E-mail inválido!';
        
        return true;
    };  

    onMounted(() => {
        LocalStorage.remove("authToken");
        LocalStorage.remove("isAttendant");
        LocalStorage.remove("siteName");            
        LocalStorage.remove("lastCheck"); 
        LocalStorage.remove("lastURL"); 
    });
</script>

<style lang="scss">
    @media (min-width: 1100px) {
        .login-form {            
            .article-login-form {
                max-width: 80vh;
                width: 80vh;
        
                border: 1px solid greenyellow;

            }
        }
    }      
</style>