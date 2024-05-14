<script setup>
import TableSync from '@/components/thematicAreas/TableSync.vue';
import useThematicAreaStore from '@/store/useThematicAreaStore';
import { useRouter } from 'vue-router';
import { Notify, useQuasar } from 'quasar';
import useThematicArea from '@composables/ThematicAreas/useThematicArea';
import { storeToRefs } from 'pinia';
import { ref } from 'vue';
import { hasPermission } from '@utils/hasPermission';
import { THEMATIC_AREA_PERMISSION } from '@utils/permissions';

const store = useThematicAreaStore();
const router = useRouter();
const filter = ref('');
const $q = useQuasar();
const { columns } = useThematicArea();
const { thematicAreas, pagination, loading } = storeToRefs(useThematicAreaStore());
async function updatePagination(event) {
  try {
    $q.loading.show();
    pagination.value = { ...event?.pagination };
    await store.fetchThematicAreas({
      limit: event.pagination?.rowsPerPage,
      page: event.pagination?.page,
      order:
        event.pagination?.descending || event?.pagination?.descending == undefined
          ? 'desc'
          : 'asc',
      column: event.pagination?.sortBy,
      search: filter.value,
    });
  } finally {
    $q.loading.hide();
  }
}
async function handleSearch() {
  await updatePagination({
    limit: pagination.value?.rowsPerPage,
    order:
      pagination.value?.descending || pagination.value?.descending == undefined
        ? 'desc'
        : 'asc',
    column: pagination.value?.sortBy,
  });
}

const onEdit = (event) => {
  router.push({
    name: 'editThematicAreas',
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
      message: 'Área temática removida com sucesso!',
    });
  } finally {
    $q.loading.hide();
    await store.fetchThematicAreas({ ...event?.pagination });
  }
};
</script>
<template>
  <div>
    <div class="row">
      <div class="col-md-4" :style="{ marginBottom: '20px' }">
        <span :style="{ fontSize: '20px', fontWeight: 'bold', color: '#3B3B3B' }">
          Gerencie a sua listagem de Áreas Temáticas
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
                v-if="hasPermission([THEMATIC_AREA_PERMISSION.CREATE])"
                label="Criar"
                color="secondary"
                icon="add"
                @click="router.push({ name: 'createThematicAreas' })"></q-btn>
            </div>
          </div>
        </div>
      </q-card-section>
      <q-card-section>
        <TableSync
          :loading="loading"
          :columns="columns"
          :rows="thematicAreas"
          :pagination="pagination"
          @update-pagination="updatePagination"
          @on-edit="onEdit"
          @on-delete="onDelete" />
      </q-card-section>
    </q-card>
  </div>
</template>
