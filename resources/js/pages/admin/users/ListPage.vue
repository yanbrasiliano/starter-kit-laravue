<script setup>
import TableSync from '@/components/users/TableSync.vue';
import { hasPermission } from '@utils/hasPermission';
import { USER_PERMISSION } from '@utils/permissions';
import useUser from '@/composables/User/useUser';
import useUserConfigListPage from '@/composables/User/useUserConfigListPage';
const { columns } = useUserConfigListPage();
const {
  router,
  filter,
  handleSearch,
  onEdit,
  onDelete,
  loading,
  rows,
  pagination,
  updatePagination,
  onStatus,
  confirmHandleStatus,
  handleStatus,
} = useUser();
</script>
<template>
  <div>
    <div class="row">
      <div class="col-md-4" :style="{ marginBottom: '20px' }">
        <span :style="{ fontSize: '20px', fontWeight: 'bold', color: '#3B3B3B' }">
          Gerencie a sua lista de usuários
        </span>
      </div>
    </div>
    <q-card>
      <q-card-section>
        <div class="row justify-between">
          <div class="col-md-4">
            <q-input v-model="filter" filled label="Pesquisar por...">
              <template #append>
                <q-icon name="search" class="cursor-pointer" @click="handleSearch" />
              </template>
            </q-input>
          </div>
          <div class="col-md-4 offset-md-4">
            <div class="column items-end">
              <q-btn
                v-if="hasPermission([USER_PERMISSION.CREATE])"
                icon="add"
                label="Criar"
                color="secondary"
                @click="router.push({ name: 'createUsers' })">
              </q-btn>
            </div>
          </div>
        </div>
      </q-card-section>
      <q-card-section>
        <TableSync
          :loading="loading"
          :columns="columns"
          :rows="rows"
          :pagination="pagination"
          :pagination-values="pagination"
          @update-pagination="updatePagination"
          @on-status="onStatus"
          @on-edit="onEdit"
          @on-delete="onDelete" />
      </q-card-section>
      <q-card> </q-card>
    </q-card>
    <q-dialog v-model="confirmHandleStatus" persistent>
      <q-card>
        <q-card-section class="row items-center">
          <span class="q-ml-sm"
            >Deseja enviar e-mail para esse usuário notificando a ativação?</span
          >
        </q-card-section>
        <q-card-actions align="center">
          <q-btn
            v-close-popup
            outline
            label="Sim"
            color="secondary"
            @click="handleStatus(true)" />
          <q-btn
            v-close-popup
            label="Não"
            color="secondary"
            @click="handleStatus(false)" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>
