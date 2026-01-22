<template>
    <q-dialog v-model="props.showDialog" persistent>
        <q-card>
            <q-card-section class="row items-center">
                <div class="">
                    <q-form
                        @submit="onSubmit"
                        class="q-gutter-md"
                    >
                        <q-input
                            v-model="text"
                            type="text"
                            label="Label"

                        />

                        <q-input
                            v-model="text"
                            type="text"
                            label="Label"
                        />

                        <q-input
                            v-model="text"
                            type="text"
                            label="Label"
                        />

                        <div>
                            <q-btn label="Submit" type="submit" color="primary"/>
                        </div>
                    </q-form>
                </div>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn
                    title="Sair"
                    icon="close"
                    color="red"
                    @click.prevent="emits('update:hiddenDialog', true)"
                />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<script setup lang="ts">
    const props = defineProps<{
        showDialog: boolean
    }>();

    const emits = defineEmits([
        'update:hiddenDialog'
    ]);

    const onSubmit = () => {

    };

</script>
