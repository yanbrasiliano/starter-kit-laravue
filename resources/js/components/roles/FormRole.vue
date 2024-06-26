<script setup>
import usePermissionStore from '@/store/usePermissionStore';
import useRoleStore from '@/store/useRoleStore';
import ErrorInput from '@components/shared/ErrorInput.vue';
import { storeToRefs } from 'pinia';
import { useQuasar } from 'quasar';
import { onBeforeMount, onUnmounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import useRole from '@/composables/Roles/useRole';

const { blockSelectPermission } = useRole();
const $q = useQuasar();
const permissionStore = usePermissionStore();
const { role, errors, loading, message, isSuccess } = storeToRefs(useRoleStore());
const roleStore = useRoleStore();
const { store, update } = roleStore;
const route = useRoute();
const router = useRouter();

onBeforeMount(async () => {
  roleStore.resetStore();
  await permissionStore.fetchPermissions();
});

onUnmounted(() => {
  roleStore.resetStore();
});

async function onSave() {
  $q.loading.show();
  const params = getParams();

  if (route.params.id) {
    await update(route.params.id, params);
  }
  await store(params);

  $q.loading.hide();

  const color = isSuccess.value ? 'positive' : 'negative';
  $q.notify({ message: message.value, color, position: 'top-right' });

  if (isSuccess.value) {
    router.push({ name: 'listRoles' });
  }
}

function getParams() {
  return {
    name: role.value?.name,
    description: role.value?.description,
    permissions: role.value.permissions,
  };
}
</script>

<template>
  <q-form v-if="role">
    <div>
      <label for="name" class="text-weight-bold">Role Name</label>
      <q-input
        v-model="role.name"
        filled
        placeholder="Enter the role name"
        bottom-slots
        lazy-rules
        :error="errors && errors?.name?.length > 0">
        <template #error>
          <ErrorInput :errors="errors.name"></ErrorInput>
        </template>
      </q-input>
    </div>
    <div>
      <label for="description" class="text-weight-bold">Description</label>
      <q-input
        v-model="role.description"
        filled
        placeholder="Enter the description"
        bottom-slots
        :error="errors && errors?.description?.length > 0">
        <template #error>
          <ErrorInput :errors="errors.description"></ErrorInput>
        </template>
      </q-input>
    </div>
    <div v-if="!blockSelectPermission()">
      <label for="permission" class="text-weight-bold">Permissions</label>
      <q-select
        v-model="role.permissions"
        multiple
        :options="permissionStore.getPermissions"
        label="Select permissions"
        filled />
    </div>
    <div class="q-mt-lg q-gutter-sm">
      <q-btn
        class="text-weight-bold"
        label="Save"
        type="submit"
        color="secondary"
        :loading="loading"
        @click.prevent="onSave" />

      <q-btn
        flat
        class="text-weight-bold"
        label="Back"
        type="submit"
        color="primary"
        :to="{ name: 'listRoles' }" />
    </div>
  </q-form>
</template>
