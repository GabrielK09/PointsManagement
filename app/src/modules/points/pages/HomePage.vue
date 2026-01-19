<template>
    <div class="points-page">
        usuário logado: {{ LocalStorage.getItem('user_name') }} - time: {{ LocalStorage.getItem('team_user') }}
        
    </div>
    <q-btn 
        color="primary" 
        icon="check" 
        label="Sair" 
        no-caps
    />
</template>

<script setup lang="ts">
    import { LocalStorage } from 'quasar';

</script>

<style lang="scss">
    .points-page {
        height: 100vh;
        display: flex;
        flex-direction: row;
        justify-content: center;
        
    }
</style>