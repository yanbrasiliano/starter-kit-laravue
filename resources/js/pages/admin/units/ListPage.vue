<script setup>
import TableSync from '@/components/units/TableSync.vue';
import useUnit from '@/composables/Unit/useUnit';
import { hasPermission } from '@utils/hasPermission';
import { UNIT_PERMISSION } from '@utils/permissions';

const {
  columns,
  onEdit,
  filter,
  loading,
  rows,
  pagination,
  updatePagination,
  onDelete,
  handleSearch,
  router,
} = useUnit();
</script>
<template>
  <div>
    <div class="row">
      <div class="col-md-4" :style="{ marginBottom: '20px' }">
        <span :style="{ fontSize: '20px', fontWeight: 'bold', color: '#3B3B3B' }">
          Gerencie a sua listagem de Unidades
        </span>
      </div>
    </div>
    <q-card>
      <q-card-section>
        <div class="row justify-between">
          <div class="col-md-4">
            <q-input v-model="filter" filled label="Pesquisar aqui...">
              <template #append>
                <q-icon name="search" class="cursor-pointer" @click="handleSearch" />
              </template>
            </q-input>
          </div>
          <div class="col-md-4 offset-md-4">
            <div class="column items-end">
              <q-btn
                v-if="hasPermission([UNIT_PERMISSION.CREATE])"
                icon="add"
                label="Criar"
                color="secondary"
                @click="router.push({ name: 'createUnits' })">
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
          @update-pagination="updatePagination"
          @on-edit="onEdit"
          @on-delete="onDelete" />
      </q-card-section>
      <q-card> </q-card>
    </q-card>
  </div>
</template>
