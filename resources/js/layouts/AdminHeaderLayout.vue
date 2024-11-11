<script setup>
import { useRouter } from 'vue-router';
import useAuthenticate from '@/composables/Authenticate/useAuthenticate';
import useAuthStore from '@/store/useAuthStore';

const authStore = useAuthStore();
const { logout } = useAuthenticate();
const router = useRouter();

const goToEditProfile = () => {
  router.push({ name: 'editUsers', params: { id: authStore.getUser?.id } });
};
</script>

<template>
  <q-header elevated>
    <q-toolbar class="bg-white text-grey-8 q-pt-xs q-pb-xs">
      <slot></slot>

      <q-btn-dropdown
        class="q-pl-xs"
        color="primary"
        flat
        round
        dense
        size="lg"
        :label="authStore.getUser?.name || 'Conta'"
        icon="account_circle">
        <q-list style="min-width: 150px">
          <q-item v-close-popup clickable @click="goToEditProfile">
            <q-item-section>
              <q-item-label>Meu Perfil</q-item-label>
            </q-item-section>
          </q-item>

          <q-item v-close-popup clickable @click="logout">
            <q-item-section>
              <q-item-label>Sair</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-btn-dropdown>
    </q-toolbar>
  </q-header>
</template>
