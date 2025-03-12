<script setup>
import Form from '@/components/users/FormUser.vue';
import useAuthStore from '@/store/useAuthStore';
import useRoleStore from '@/store/useRoleStore';
import useUserStore from '@/store/useUserStore';
import { format } from 'date-fns';
import { Notify, useQuasar } from 'quasar';
import { computed, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const userStore = useUserStore();
const authStore = useAuthStore();
const roleStore = useRoleStore();
const router = useRouter();
const route = useRoute();
const $q = useQuasar();

const loading = ref(false);
const user = ref(null);
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
    throw new Error(`Falha ao buscar os perfis: ${error.message || error}`);
  } finally {
    $q.loading.hide();
  }
};

const loadUserData = async () => {
  try {
    await userStore.consult(route.params.id);
    user.value = userStore.getUser;

    if (!user.value) {
      notify('Usuário não encontrado', 'negative');
    }
  } catch (error) {
    throw new Error(`Falha ao carregar os dados do usuário: ${error.message || error}`);
  }
};

onMounted(async () => {
  userStore.clearStore();
  await loadRoles();
  await loadUserData();
});

const formattedDate = computed(() => {
  return user.value?.created_at
    ? format(new Date(user.value.created_at), 'MM/dd/yyyy HH:mm:ss')
    : '';
});

const send = async (payload) => {
  try {
    loading.value = true;
    const updatedUser = await userStore.update(route.params.id, payload);

    if (authStore.user?.id === updatedUser?.id) {
      authStore.setCredentials({ user: updatedUser });
    }

    notify('Usuário atualizado com sucesso', 'positive');
    router.push({ name: 'listUsers' });
  } catch (error) {
    throw new Error(`Falha ao atualizar o usuário: ${error.message || error}`);
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div>
    <div class="row">
      <div class="col-md-4 q-mb-md">
        <span class="text-weight-bold title__page--style"> Editar Usuário </span>
      </div>
    </div>
    <q-card class="q-pa-md">
      <q-card-section>
        <div class="row justify-end">
          <span class="text-weight-bold"> Criado em: {{ formattedDate }} </span>
        </div>
        <Form
          v-if="profilesAvailable && user"
          :loading="loading"
          :profiles="roleStore.getAllRoles"
          :user="user"
          @send="send" />
        <div v-else class="text-subtitle1 text-center q-my-md">Carregando...</div>
      </q-card-section>
    </q-card>
  </div>
</template>
