<script setup>
import Form from '@/components/users/FormUser.vue';
import useRoleStore from '@/store/useRoleStore';
import useUserStore from '@/store/useUserStore';
import notify from '@/utils/notify';
import { useQuasar } from 'quasar';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const $q = useQuasar();
const userStore = useUserStore();
const router = useRouter();
const loading = ref(false);
const roleStore = useRoleStore();
const profilesAvailable = ref(false);

const loadRoles = async () => {
  $q.loading.show();
  try {
    await roleStore.listAll();
    profilesAvailable.value = roleStore.getAllRoles.length > 0;

    if (!profilesAvailable.value) {
      notify('Não foi possível carregar os perfis', 'negative');
    }
  } catch (error) {
    throw new Error(`Falha ao buscar os perfis: ${error.message || error}`);
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
    throw new Error(`Falha ao registrar o usuário: ${error.message || error}`);
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div>
    <div class="row">
      <div class="col-md-4 q-mb-md">
        <span class="text-weight-bold title__page--style"> Cadastra o seu Usuário </span>
      </div>
    </div>
    <q-card class="q-pa-md">
      <q-separator inset />
      <q-card-section>
        <Form
          v-if="profilesAvailable"
          :loading="loading"
          :profiles="roleStore.getAllRoles"
          @send="send" />
        <div v-else class="text-subtitle1 text-center q-my-md">Carregando...</div>
      </q-card-section>
    </q-card>
  </div>
</template>
