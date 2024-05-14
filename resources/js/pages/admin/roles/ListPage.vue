<script setup>
import TableSync from '@/components/roles/TableSync.vue';
import useRoleStore from '@/store/useRoleStore';
import { useRouter } from 'vue-router';
import { Notify, useQuasar } from 'quasar';
import useRoleConfigListPage from '@composables/Roles/useRoleConfigListPage';
import { storeToRefs } from 'pinia';
import { hasPermission } from '@utils/hasPermission';
import { ROLE_PERMISSION } from '@utils/permissions';

const store = useRoleStore();
const router = useRouter();
const $q = useQuasar();
const { columns } = useRoleConfigListPage();

const { roles, pagination, loading } = storeToRefs(useRoleStore());

async function updatePagination(event) {
  try {
    $q.loading.show();
    pagination.value = { ...event?.pagination };
    await store.fetchRoles({ ...event?.pagination });
  } finally {
    $q.loading.hide();
  }
}

const onEdit = (event) => {
  router.push({
    name: 'editRoles',
    params: {
      id: event.id,
    },
  });
};

const onDelete = async (event) => {
  try {
    $q.loading.show();
    await store.destroy(event.id);
    Notify.create({
      position: 'top-right',
      color: 'positive',
      message: 'Perfil removido com sucesso!',
    });
  } finally {
    $q.loading.hide();

    await store.fetchRoles({ ...pagination.value });
  }
};
</script>
<template>
  <div>
    <div class="row">
      <div class="col-md-4" :style="{ marginBottom: '20px' }">
        <span :style="{ fontSize: '20px', fontWeight: 'bold', color: '#3B3B3B' }">
          Gerencie a sua listagem de perfis de acesso
        </span>
      </div>
    </div>
    <q-card>
      <q-card-section>
        <div class="row justify-end">
          <div class="col-md-4 offset-md-4">
            <div class="column items-end">
              <q-btn
                v-if="hasPermission([ROLE_PERMISSION.CREATE])"
                label="Criar"
                color="secondary"
                icon="add"
                @click="router.push({ name: 'createRoles' })"></q-btn>
            </div>
          </div>
        </div>
      </q-card-section>
      <q-card-section>
        <TableSync
          :loading="loading"
          :columns="columns"
          :rows="roles"
          :pagination="pagination"
          @update-pagination="updatePagination"
          @on-edit="onEdit"
          @on-delete="onDelete" />
      </q-card-section>
    </q-card>
  </div>
</template>
