<script setup>
import Form from '@/components/users/FormUser.vue';
import { onMounted, ref } from 'vue';
import useUserStore from '@/store/useUserStore';
import { useRouter } from 'vue-router';
import { Notify, useQuasar } from 'quasar';
import useRoleStore from '@/store/useRoleStore';

const $q = useQuasar();
const userStore = useUserStore();
const router = useRouter();
const loading = ref(false);
const roleStore = useRoleStore();
const profilesAvailable = ref(false);

const notify = (message, color) => {
  Notify.create({
    position: 'top-right',
    color: color,
    message: message,
  });
};

const loadRoles = async () => {
  $q.loading.show();
  try {
    await roleStore.listAll();
    profilesAvailable.value = roleStore.getAllRoles.length > 0;
    if (!profilesAvailable.value) {
      notify('Não foi possível carregar os perfis', 'negative');
    }
  } catch (error) {
    console.error('Failed to fetch roles:', error);
  } finally {
    $q.loading.hide();
  }
};

onMounted(loadRoles);

const send = async (payload) => {
  try {
    loading.value = true;
    await userStore.store(payload);
    notify('Usuário registrado com sucesso', 'positive');
    router.push({ name: 'listUsers' });
  } catch (error) {
    console.error('Failed to store user:', error);
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div class="q-pa-md items-start q-gutter-md">
    <q-card class="q-pa-md">
      <q-card-section>
        <div class="row text-h5 q-mt-sm q-mb-xs text-weight-bold">
          Cadastra o seu Usuário
        </div>
      </q-card-section>
      <q-separator inset />
      <q-card-section>
        <Form
          v-if="profilesAvailable"
          :loading="loading"
          :profiles="roleStore.getAllRoles"
          @send="send" />
        <div v-else class="text-subtitle1 text-center q-my-md">
          No profiles available. Please try again later.
        </div>
      </q-card-section>
    </q-card>
  </div>
</template>
