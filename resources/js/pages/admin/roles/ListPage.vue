<script setup>
import TableSync from '@/components/roles/TableSync.vue';
import { useRouter } from 'vue-router';
import useRoleConfigListPage from '@composables/Roles/useRoleConfigListPage';
import useRole from '@composables/Roles/useRole';
import { hasPermission } from '@utils/hasPermission';
import { ROLE_PERMISSION } from '@utils/permissions';

const router = useRouter();
const { loading, roles, pagination, updatePagination, onEdit, onDelete } = useRole();
const { columns } = useRoleConfigListPage();
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
