<script setup>
import TableSync from '@/components/roles/TableSync.vue';
import PageTopTitle from '@/components/shared/PageTopTitle.vue';
import useRole from '@composables/Roles/useRole';
import useRoleConfigListPage from '@composables/Roles/useRoleConfigListPage';
import { hasPermission } from '@utils/hasPermission';
import { ROLE_PERMISSION } from '@utils/permissions';
import { useRouter } from 'vue-router';

const router = useRouter();
const { loading, roles, pagination, updatePagination, onEdit, onDelete } = useRole();
const { columns } = useRoleConfigListPage();
</script>
<template>
  <div>
    <div class="row">
      <div class="col-md-4" :style="{ marginBottom: '20px' }">
        <PageTopTitle>Gerencie a sua listagem de perfis de acesso</PageTopTitle>
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
