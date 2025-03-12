<script setup>
import useRole from '@/composables/Roles/useRole';
import usePermissionStore from '@/store/usePermissionStore';
import ErrorInput from '@components/shared/ErrorInput.vue';
import { onBeforeMount, onUnmounted } from 'vue';

const {
  role,
  errors,
  loading,
  selectedPermissionIds,
  shouldBlockSelectPermission,
  togglePermission,
  saveRole,
  initializeRoleData,
  cleanupRoleData,
} = useRole();

const permissionStore = usePermissionStore();

onBeforeMount(async () => {
  await initializeRoleData();
});

onUnmounted(() => {
  cleanupRoleData();
});
</script>

<template>
  <q-form v-if="role">
    <div>
      <label for="name" class="text-weight-bold">
        Nome do Perfil <span class="text-negative">*</span>
      </label>
      <q-input
        v-model="role.name"
        filled
        placeholder="Campo obrigatório."
        bottom-slots
        lazy-rules
        :error="errors && errors?.name?.length > 0">
        <template #error>
          <ErrorInput :errors="errors.name"></ErrorInput>
        </template>
      </q-input>
    </div>
    <div>
      <label for="description" class="text-weight-bold">Descrição</label>
      <q-input
        v-model="role.description"
        filled
        placeholder="Texto não obrigatório."
        bottom-slots
        :error="errors && errors?.description?.length > 0">
        <template #error>
          <ErrorInput :errors="errors.description"></ErrorInput>
        </template>
      </q-input>
    </div>
    <div v-if="!shouldBlockSelectPermission" class="q-mt-md">
      <label class="text-weight-bold">Permissões</label>
      <div class="q-mt-sm q-gutter-y-sm">
        <q-card flat bordered>
          <q-card-section>
            <div class="row q-col-gutter-md">
              <div
                v-for="permission in permissionStore.getPermissions"
                :key="permission.value"
                class="col-12 col-sm-6 col-md-4">
                <q-checkbox
                  :model-value="selectedPermissionIds.includes(permission.value)"
                  :label="permission.label"
                  :disable="shouldBlockSelectPermission"
                  @update:model-value="togglePermission(permission.value)" />
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>
    </div>
    <div class="q-mt-lg q-gutter-sm">
      <q-btn
        class="text-weight-bold"
        label="Salvar"
        type="submit"
        color="secondary"
        :loading="loading"
        @click.prevent="saveRole()" />

      <q-btn
        flat
        class="text-weight-bold"
        label="Voltar"
        type="submit"
        color="primary"
        :to="{ name: 'listRoles' }" />
    </div>
  </q-form>
</template>
