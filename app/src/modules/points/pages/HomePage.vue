<template>
    <div class="card-container bg-[#FBFEF9] rounded-xl">
        <div class="cards">
            <div class="flex" v-for="user in users">
                <q-card class="rounded-xl p-2">
                    <q-card-section>
                        <div class="text-h6">{{ user.name }}</div>

                    </q-card-section>

                    <q-card-section>
                        <div v-for="btn in btns">
                            <q-btn
                                v-if="btn.show"
                                no-caps
                                :color="btn.color || 'black'" 
                                :label="btn.label" 
                            >
                                <span class="ml-4">
                                    {{ btn.count }}
                                </span>
                            </q-btn>        
                        </div>
                    </q-card-section>
                </q-card>
            </div>
        </div>

        <pre>{{ users }}</pre>
    </div>
</template>

<script setup lang="ts">
    import { onMounted, ref } from 'vue';
    import { getAllUsersService } from '../services/userServicet';

    interface QBtnAction {
        label: string;
        color: string;
        action: string;
        icon: string;
        show: boolean;
        count: number,
    };

    const btns = ref<QBtnAction[]>([
        {
            label: 'Puxei',
            action: '',
            icon: '',
            color: '',
            show: true,
            count: 0,
        },
        {
            label: 'Liguei',
            action: '',
            icon: '',
            color: '',
            show: true,
            count: 0,
        },
        {
            label: 'Whats Interno',
            action: '',
            icon: '',
            color: '',
            show: true,
            count: 0,
        },
        {
            label: 'Indiquei',
            action: '',
            icon: '',
            color: '',
            show: true,
            count: 0,
        },
        {
            label: 'Xremote',
            action: '',
            icon: '',
            color: '',
            show: true,
            count: 0,
        },
        {
            label: 'Chat',
            action: '',
            icon: '',
            color: '',
            show: true,
            count: 0,
        },
        {
            label: 'SuperBio',
            action: '',
            icon: '',
            color: '',
            show: false,
            count: 0,
        },
    ]);

    const users = ref<UserContract[]>([]);
    
    const getUsers = async (): Promise<void> => {
        const res = await getAllUsersService();

        users.value = res.data;
    };

    onMounted(() => {
        getUsers();

    });
</script>

<style lang="scss">
    .card-container {
        margin: 0 4rem 0 4rem;
        padding: 15px;

        .cards {
            max-width: max-content;
        }
        
        @media (min-width: 1100px) {
            .cards {
                width: 30%;
            }
        }

        @media (max-width: 1100px) {
            .cards {
                width: 70%;
            }
        }
    }
</style>