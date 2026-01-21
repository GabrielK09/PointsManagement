<template>
    <q-layout view="hHr LpR lFf">
        <q-btn 
            @click="drawerLeft = !drawerLeft" 
            flat 
            class="rounded" 
            icon="menu" 

        />

        <q-drawer
            v-model="drawerLeft"
            show-if-above
            :width="210"
            class="bg-[#03202e] text-white rounded-r-md dashboard"
        >
            <span class="flex justify-center mt-4 text-sm">Usuário: {{ LocalStorage.getItem('user_name') }}</span> 

            <q-toolbar>
                <q-list padding class="p-2">
                    <q-item 
                        v-for="row in userRows"
                        v-ripple
                        clickable
                        :key="row.name"
                        :to="`/points/${row.path}`"
                        :active="route.path === row.path"
                        class="rounded mt-3"
                        active-class="my-link"
                    >
                        <q-item-section avatar>
                            <q-icon :name="row.icon" />
                        </q-item-section>

                        <q-item-section>
                            {{ row.label }}
                        </q-item-section>

                    </q-item>
                </q-list>
            </q-toolbar>

            <div class="fixed bottom-0 flex flex-center mt-4 bg-[#03202e] fixed-logout-button">
                <q-btn 
                    class="mb-4" 
                    icon="logout" 
                    flat 
                    no-caps
                    label="Sair"
                    @click="logoutDialog"
                />
            </div>
        </q-drawer>

        <q-page-container>
            <router-view />
        </q-page-container>
    </q-layout> 
    
</template>

<script setup lang="ts">
    import { onMounted, ref } from 'vue';
    import { useRoute, useRouter } from 'vue-router';
    import { LocalStorage, useQuasar } from 'quasar';
    import { logoutService } from 'src/modules/auth/services/authService';
    
    interface UserRow {
        label: string;
        icon: string;
        name: string;
        path: string;
    };

    const $q = useQuasar();
    const route = useRoute();
    const router = useRouter();
    const drawerLeft = ref<boolean>(true);
    
    const userRows = ref<UserRow[]>([
        { label: 'DashBoard', icon: 'dashboard', name: 'dashboard', path: ''},
        { label: 'Técnicos', icon: 'assignment_ind', name: 'assignment_ind', path: ''},

    ]);

    const logoutDialog = (): void => {
        $q.dialog({
            message: 'Deseja realmente sair?',
            cancel: {
                label: 'Não',
                color: 'red',
                push: true
            },

            ok: {
                label: 'Sim',
                color: 'green',
                push: true
            }
        }).onCancel(() => {
            return;

        }).onOk(() => {
            logout();

        });
    };

    const logout = async(): Promise<void>=> {
        const res = await logoutService();

        if(res.success)
        {
            $q.notify({
                type: 'positive',
                message: res.message,
                position: 'top'
            });

            LocalStorage.remove('auth_token');
            LocalStorage.remove('user_id');
            LocalStorage.remove('user');

            router.push({
                path: '/login'
            })
        } else {
            $q.notify({
                type: 'negative',
                message: res.message,
                position: 'top'
            });
        };
    };

    onMounted(() => {
        if(LocalStorage.getItem('auth_token') === '' || LocalStorage.getItem('auth_token') === null)
        {
            $q.notify({
                message: 'Usuário deslogado.',
                position: 'top',
                type: 'negative'
            });

            router.replace({
                path: '/login'
            });
        };
    })

</script>

<style lang="scss">
    .dashboard {
        height: 100vh;

    }

    .my-link {
        color: #fff;
        background: #07425f;
    }

    .fixed-logout-button {
        position: fixed;
        bottom: 0;
        margin-left: 3rem;
    }

    @media (max-width: 1100px) {
        .fixed-logout-button {
            position: fixed;
            bottom: 0;
            margin-left: 3rem;
        }   
    }
</style>