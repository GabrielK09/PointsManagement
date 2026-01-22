<template>
    <q-page padding>
        <section>
            <div
                class="m-2"
            >
                <div class="flex justify-between">
                    <div class="flex">
                        <h3 class="text-gray-600 m-2">Técnicos</h3>

                    </div>

                    <div class="mt-auto mb-auto">
                        <q-btn
                            no-caps
                            color="blue"
                            class="text-white"
                            label="Cadastrar novo técnico"
                            @click="showTechnicelRegister = !showTechnicelRegister"
                        />
                    </div>
                </div>

                <div>
                    <q-table
                        borded
                        :rows="technicals"
                        :columns="columns"
                        row-key="name"
                        class="rounded-xl"
                        :filter="searchInput"
                    >
                        <template v-slot:top-right>
                            <q-input
                                outlined
                                v-model="searchInput"
                                type="text"
                                label=""
                            >
                                <template v-slot:append>
                                    <q-icon name="search" />
                                </template>

                                <template v-slot:label>
                                    <span class="text-xs">Buscar por um técnico(a) ...</span>
                                </template>
                            </q-input>
                        </template>

                        <template v-slot:body="props">
                            <q-tr
                                :props="props"
                            >
                                <q-td
                                    class="overflow-hidden z-50"
                                    v-for="col in props.cols"
                                    :key="col.name"
                                    :props="props"
                                >
                                    <template v-if="col.name === 'actions'">
                                        <q-btn
                                            color="red"
                                            icon="delete"

                                        />

                                        <q-menu
                                            transition-show="jump-down"
                                            transition-hide="jump-up"
                                        >

                                        </q-menu>
                                    </template>

                                    <template v-else>

                                        {{ col.value }}
                                    </template>
                                </q-td>
                            </q-tr>
                        </template>

                        <template v-slot:no-data>
                            <div class="ml-auto mr-auto">
                                <q-icon name="warning" size="30px"/>
                                <span class="mt-auto mb-auto ml-2 text-xs">Sem técnicos cadastrados</span>

                            </div>
                        </template>
                    </q-table>
                </div>
            </div>
        </section>
    </q-page>

    <RegisterTechnical
        v-if="showTechnicelRegister"
        :show-dialog="showTechnicelRegister"
        @update:hidden-dialog="showTechnicelRegister = !$event"
    />
</template>

<script setup lang="ts">
    import { QTableColumn, LocalStorage, useQuasar } from 'quasar';
    import RegisterTechnical from 'src/components/Technical/RegisterTechnical.vue';
    import { getAllUsersService } from 'src/modules/points/services/userService.ts';
    import { onMounted, ref } from 'vue';

    const $q = useQuasar();
    const searchInput = ref('');

    const allTechnicals = ref<UserContract[]>([]);
    const technicals = ref<UserContract[]>([]);

    const columns: QTableColumn[] = [
        {
            field: 'id',
            label: 'ID',
            name: 'id',
            align: 'center'
        },
        {
            field: 'name',
            label: 'Nome',
            name: 'name',
            align: 'center'
        },
        {
            field: 'actions',
            label: 'Ações',
            name: 'actions',
            align: 'center'
        }
    ];

    let showTechnicelRegister = ref<boolean>(false);
    let selectedTechnical = ref<string>('');
    let selectedTechnicalId = ref<string>('');

    const index = async (): Promise<void> => {
        const res = await getAllUsersService();

        if(res.success)
        {
            technicals.value = res.data;
            allTechnicals.value = [...technicals.value];
        };
    };

    const showDialogDisableTechnical = (technicelId: string, currentStatus: number): void  => {
        $q.dialog({
            title: `Deseja realmente ${currentStatus === 1 ? 'desativar' : 'ativar'} esse técnico?`,
            ok: {
                label: 'Sim',
                color: 'green'

            },
            cancel: {
                label: 'Não',
                color: 'red'

            }
        }).onOk(() => {
            disableOrActiveTechnical(technicelId, currentStatus === 1 ? 'disable' : 'active');

        }).onCancel(() => {
            return;

        });
    };

    const disableOrActiveTechnical = async (technicelId: string, action: string): Promise<void> => {

    };

    onMounted(() => {
        index();
    });
</script>

<style lang="scss">
    .delete-btn {
        font-size: .55rem;
    }

    @media (max-width: 1100px) {
        .delete-btn,
        .edit-btn,
        .attach_money-btn {
            display: none;
        }
    }

</style>
