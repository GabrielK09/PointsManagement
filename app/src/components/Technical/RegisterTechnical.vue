<template>
    <q-dialog v-model="props.showDialog" persistent>
        <q-card>
            <q-card-section class="row items-center">
                <div class="">
                    <q-form
                        @submit="createUser"
                        class="q-gutter-md"
                    >
                        <q-input
                            v-model="user.name"
                            type="text"
                            label="Nome"
                            stack-label
                            :error="!!formErrors.name"
                            :error-message="formErrors.name"
                        />

                        <q-input
                            v-model="user.email"
                            type="text"
                            label="E-mail"
                            stack-label
                            :error="!!formErrors.email"
                            :error-message="formErrors.email"
                        />

                        <q-input
                            v-model="user.password"
                            type="password"
                            label="Senha"
                            stack-label
                            :error="!!formErrors.password"
                            :error-message="formErrors.password"
                        />

                        <q-card-actions align="right">
                            <q-btn
                                no-caps
                                label="Criar"
                                type="submit"
                                color="primary"
                                :loading="loadingLogin"
                            />

                            <q-btn
                                title="Sair"
                                icon="close"
                                color="red"
                                @click.prevent="emits('update:hiddenDialog', true)"
                            />
                        </q-card-actions>

                    </q-form>
                </div>
            </q-card-section>
        </q-card>
    </q-dialog>
</template>

<script setup lang="ts">
    import { useQuasar } from 'quasar';
    import { createUserService } from 'src/modules/technicals/services/technicalsService';
    import { ref } from 'vue';
    import * as Yup from 'yup';

    const $q = useQuasar();

    const props = defineProps<{
        showDialog: boolean
    }>();

    const emits = defineEmits([
        'update:hiddenDialog'
    ]);

    const formErrors = ref<Record<string, string>>({});

    const userSchema = Yup.object({
        name: Yup.string().required('O nome é obrigatório!'),
        email: Yup.string().email('O e-mail precisa estar em um formato válido').required('O e-mail é obrigatório!'),
        password: Yup.string().min(8, 'A senha do usuário precisa ter um minímo de 8 caracteres!').max(120, 'A senha do usuário precisa ter um máximo de 120 caracteres!').required('A senha é obrigatório!')
    });

    const user = ref<UserContract>({
        id: '',
        name: '',
        email: '',
        password: '',
        team: '',
        pulled: 0,
        called: 0,
        whatsApp: 0,
        indicate: 0,
        xremote: 0,
        chat: 0
    });

    let loadingLogin = ref<boolean>(false);

    const createUser = async () => {
        loadingLogin.value = true;
        try {
            await userSchema.validate(user.value, { abortEarly: false });

            const res = await createUserService(user.value);

            if(!res.success)
            {
                $q.notify({
                    message: res.message,
                    position: 'top',
                    type: 'negative'
                });
            } else {
                $q.notify({
                    message: res.message,
                    position: 'top',
                    type: 'positive'
                });

                emits('update:hiddenDialog', true)

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
