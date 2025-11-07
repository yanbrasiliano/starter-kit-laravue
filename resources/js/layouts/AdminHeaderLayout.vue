<script setup>
import useAuthenticate from '@/composables/Authenticate/useAuthenticate';
import useAuthStore from '@/store/useAuthStore';
import { computed } from 'vue';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const { logout } = useAuthenticate();
const router = useRouter();

const goToViewProfile = () => {
  router.push({ name: 'showUsers', params: { id: authStore.getUser?.id } });
};

const userInitials = computed(() => {
  const name = authStore.getUser?.name?.trim() || '';
  if (!name) return '';

  const parts = name.split(' ').filter(Boolean);
  if (parts.length > 1) {
    return (parts[0][0] + parts[1][0]).toUpperCase();
  }

  const first = parts[0].substring(0, 2).toUpperCase();
  return first.padEnd(2, first[first.length - 1]);
});
</script>

<template>
  <q-header elevated class="header-custom">
    <q-toolbar class="bg-white text-grey-8 q-pt-xs q-pb-xs toolbar-custom">
      <slot></slot>

      <q-btn
        class="question-mark"
        round
        dense
        size="sm"
        unelevated
        color="secondary"
        icon="question_mark">
        <q-tooltip anchor="top middle" self="bottom middle">
          Para mais dúvidas, entre em contato com o administrador do sistema.
        </q-tooltip>
      </q-btn>

      <q-btn-dropdown
        class="q-pl-xs dropdown__header--style"
        color="primary"
        flat
        round
        dense
        size="md">
        <template #label>
          <div class="flex items-center">
            <q-avatar color="primary" text-color="white" size="32px">
              {{ userInitials }}
            </q-avatar>
            <span class="q-ml-sm">{{ authStore.getUser?.name || 'Conta' }}</span>
          </div>
        </template>

        <q-list>
          <q-item v-close-popup clickable @click="goToViewProfile">
            <q-item-section avatar>
              <q-icon name="person" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Meu Perfil</q-item-label>
            </q-item-section>
          </q-item>

          <q-item v-close-popup clickable @click="logout">
            <q-item-section avatar>
              <q-icon name="logout" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Sair</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-btn-dropdown>
    </q-toolbar>
  </q-header>
</template>
