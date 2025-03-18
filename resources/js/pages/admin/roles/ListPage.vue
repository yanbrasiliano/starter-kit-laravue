<script setup>
import TableSync from '@/components/roles/TableSync.vue';
import PageTopTitle from '@/components/shared/PageTopTitle.vue';
import SearchInput from '@/components/shared/SearchInput.vue';
import PageWrapper from '@/pages/admin/PageWrapper.vue';
import useRole from '@composables/Roles/useRole';
import useRoleConfigListPage from '@composables/Roles/useRoleConfigListPage';
import { hasPermission } from '@utils/hasPermission';
import { ROLE_PERMISSION } from '@utils/permissions';
import { useRouter } from 'vue-router';

const router = useRouter();
const { loading, rows, pagination, handleSearch, updatePagination, onEdit, onDelete } =
  useRole();
const { columns } = useRoleConfigListPage();
</script>
<template>
  <PageWrapper>
    <template #title>
      <PageTopTitle>Gerencie os seus perfis de acesso</PageTopTitle>
    </template>
    <template #actions>
      <div class="row justify-between">
        <div class="col-md-4">
          <SearchInput @update-search="handleSearch" @trigger-search="handleSearch" />
        </div>
        <div class="col-md-4 offset-md-4">
          <div class="column items-end">
            <q-btn
              v-if="hasPermission([ROLE_PERMISSION.CREATE])"
              label="Criar"
              color="accent"
              icon="add"
              @click="router.push({ name: 'createRoles' })"></q-btn>
          </div>
        </div>
      </div>
    </template>
    <template #content>
      <TableSync
        :loading="loading"
        :columns="columns"
        :rows="rows"
        :pagination="pagination"
        @update-pagination="updatePagination"
        @on-edit="onEdit"
        @on-delete="onDelete" />
    </template>
  </PageWrapper>
</template>
