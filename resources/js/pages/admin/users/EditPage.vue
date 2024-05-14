<script setup>
import { computed, onMounted, ref } from 'vue';
import useUserStore from '@/store/useUserStore';
import useRoleStore from '@/store/useRoleStore';
import { useRoute, useRouter } from 'vue-router';
import { Notify, useQuasar } from 'quasar';
import { format } from 'date-fns';
import Form from '@/components/users/FormUser.vue';
import useAuthStore from '@/store/useAuthStore';

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
      notify('Unable to load user profiles!', 'negative');
    }
  } catch (error) {
    notify('Error loading profiles!', 'negative');
    console.error('Failed to fetch roles:', error);
  } finally {
    $q.loading.hide();
  }
};

const loadUserData = async () => {
  try {
    await userStore.consult(route.params.id);
    user.value = userStore.getUser;
    if (!user.value) {
      notify('User not found!', 'negative');
    }
  } catch (error) {
    notify('Error loading user data!', 'negative');
    console.error('Failed to load user data:', error);
  }
};

onMounted(async () => {
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
    notify('User successfully updated!', 'positive');
    router.push({ name: 'listUsers' });
  } catch (error) {
    notify('Error updating user!', 'negative');
    console.error('Failed to update user:', error);
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div class="q-pa-md items-start q-gutter-md">
    <q-card class="q-pa-md">
      <q-card-section>
        <div class="row text-h5 q-mt-sm q-mb-xs text-weight-bold">Edit your users</div>
      </q-card-section>
      <q-separator inset />
      <q-card-section>
        <div class="row justify-end">
          <span class="text-weight-bold"> Created on: {{ formattedDate }} </span>
        </div>
        <Form
          v-if="profilesAvailable && user"
          :loading="loading"
          :profiles="roleStore.getAllRoles"
          :user="user"
          @send="send" />
        <div v-else class="text-subtitle1 text-center q-my-md">Loading...</div>
      </q-card-section>
    </q-card>
  </div>
</template>
