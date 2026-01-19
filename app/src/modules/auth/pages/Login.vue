<template>
    <div class="login-form">
        <q-form
            class="q-gutter-md bg-gray-50 border border-gray-200 rounded-md p-8"
        >
            <h4 class="text-center text-xl">Login</h4>

            <div class="inputs p-2">
                <q-input 
                    v-model="loginData.email" 
                    type="text" 
                    label="E-mail" 
                    stack-label
                    class="input-email"
                    :error="!!formErrors.email"
                    :error-message="formErrors.email"
                    :rules="[
                        val => !!val || 'Informe o seu e-mail!'
                    ]"

                />

                <q-input 
                    v-model="loginData.password" 
                    :type="!showPassword ? 'password' : 'text'" 
                    label="Senha" 
                    stack-label
                    class="input-password"
                    :no-error-icon="!formErrors.password"
                    :error="!!formErrors.password"
                    :error-message="formErrors.password"
                    :rules="[
                        val => !!val || 'Informe a sua senha!'
                    ]"
                >
                    <template v-slot:append v-if="!formErrors.password">
                        <svg 
                            v-if="!showPassword"
                            @click="showPassword = !showPassword"
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke-width="1.5" 
                            stroke="currentColor" 
                            class="size-6 cursor-pointer"
                            >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                        <svg 
                            v-if="showPassword"
                            @click="showPassword = !showPassword"
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke-width="1.5" 
                            stroke="currentColor" 
                            class="size-6 cursor-pointer"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </template>
                </q-input>
            </div>
            
            <div class="flex justify-center">
                <div class="flex flex-col w-full">
                    <q-btn 
                        label="Entrar" 
                        color="primary" 
                        no-caps
                        @click="submitLogin"
                        :loading="loadingLogin"
                    />
                </div>
            </div>
        </q-form>
    </div>
</template>

<script setup lang="ts">
    import { ref } from 'vue';
    import { LocalStorage, useQuasar } from 'quasar';
    import { loginService } from 'src/modules/auth/services/authService';
    import { useRouter } from 'vue-router';
    import * as Yup from 'yup';

    interface authContract {
        email: string;
        password: string;
    };

    const router = useRouter();
    const $q = useQuasar();

    let loadingLogin = ref<boolean>(false);
    let showPassword = ref<boolean>(false);

    const formErrors = ref<Record<string, string>>({});

    const loginSchema = Yup.object({
        email: Yup.string().required('O e-mail é obrigatório!'),
        password: Yup.string().required('A senha é obrigatório!')

    });

    const loginData = ref<authContract>({
        email: '',
        password: ''
    });

    const submitLogin = async () => {
        loadingLogin.value = true;
        const res = await loginService(loginData.value.email, loginData.value.password);
        
        try {        
            await loginSchema.validate(loginData.value, { abortEarly: false });
        
            $q.notify({
                type: 'positive',
                message: 'Validando dados de login ...',
                position: 'top'
                
            }); 
                    
            if(res.success)
            {            
                LocalStorage.set('auth_token', res.data.token);
                LocalStorage.set('user_name', res.data.user.name);
                LocalStorage.set('user_team', res.data.user.team);
    
                $q.notify({
                    type: 'positive',
                    message: res.message,
                    position: 'top'
                    
                });
                
                router.replace({ 
                    path: '/points/home' 
                });
    
            } else {
                $q.notify({
                    type: 'negative',
                    message: res.message,
                    position: 'top'
    
                });
            };
            
        } catch (error) {
            if(error.inner)
            {
                formErrors.value = {};

                error.inner.forEach((err: any) => {
                    formErrors.value[err.path] = err.message;

                    $q.notify({
                        type: 'negative',
                        position: 'top',
                        message: err.message

                    });
                });  
            } else {
                $q.notify({
                    type: 'negative',
                    position: 'top',
                    message: error.response?.data?.message

                });
            };
        } finally {
            loadingLogin.value = false;

        };       
    };
</script>

<style lang="scss">
    .login-form {
        height: 100vh;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;

        .inputs {
            .input-email, .input-password {
                margin: 10px;
                width: 20rem;

            }
        }
    }
</style>