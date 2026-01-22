<template>
    <div class="card-container bg-[#f2f3f2] rounded-xl">
        <div v-if="users.length < 1" class="flex flex-center">
            <q-circular-progress
                indeterminate
                size="90px"
                :thickness="0.2"
                color="grey-8"
                center-color="white"
                track-color="transparent"
                class="q-ma-md"
            />
        </div>

        <div v-else class="cards">
            <div
                class="card"
                v-for="user in users"
            >
                <q-card class="rounded-xl p-2">
                    <q-card-section>
                        <div class="text-h6 text-center">{{ user.name }}</div>

                    </q-card-section>

                    <q-card-section>
                        <div class="flex flex-center gap-4">
                           <q-btn
                                no-caps
                                label="Puxei"
                                color="purple"
                                @click="addGoal('pulled')"
                            >
                                <span class="ml-2">{{ user.pulled }}</span>
                            </q-btn>

                            <q-btn
                                no-caps
                                label="Liguei"
                                color="primary"
                                @click="addGoal('called')"
                            >
                                <span class="ml-2">{{ user.called }}</span>
                            </q-btn>

                            <q-btn
                                no-caps
                                label="Whats interno"
                                color="green"
                                @click="addGoal('whatsApp')"
                            >
                                <span class="ml-2">{{ user.whatsApp }}</span>
                            </q-btn>

                            <q-btn
                                no-caps
                                label="Indiquei"
                                color="teal"
                                @click="addGoal('indicate')"
                            >
                                <span class="ml-2">{{ user.indicate }}</span>
                            </q-btn>

                            <q-btn
                                no-caps
                                label="Xremote"
                                color="orange"
                                @click="addGoal('xremote')"
                            >
                                <span class="ml-2">{{ user.xremote }}</span>
                            </q-btn>

                            <q-btn
                                no-caps
                                label="Chat"
                                color="cyan"
                                text-color="white"
                                @click="addGoal('chat')"
                            >
                                <span class="ml-2">{{ user.chat }}</span>
                            </q-btn>
                        </div>
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import { onMounted, ref } from 'vue';
     import { getAllUsersService } from '../services/userService';
    import { useQuasar } from 'quasar';

    const $q = useQuasar();
    const users = ref<UserContract[]>([]);

    const getUsers = async (): Promise<void> => {
        const res = await getAllUsersService();

        if(!res.success)
        {
            $q.notify({
                message: res.message,
                position: 'top',
                type: 'negative'
            });
        };

        users.value = res.data;
    };

    const addGoal = async (goalType: string): Promise<any> => {

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
                width: 40%;
            }
        }

        @media (max-width: 1100px) {
            .cards {
                width: 50%;
            }
        }
    }
</style>
