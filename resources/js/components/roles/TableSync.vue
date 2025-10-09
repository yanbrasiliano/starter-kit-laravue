<script setup>
import Pagination from '@/components/shared/Pagination.vue';
import useRole from '@/composables/Roles/useRole';
import { ref } from 'vue';

const {
  shouldBlockEditRoleAdmin,
  shouldBlockDeleteRoleUserAuth,
  shouldBlockDeleteProtectedRole,
} = useRole();

const emit = defineEmits(['updatePagination', 'onConsult', 'onEdit', 'onDelete']);

const loading = ref(false);
const pagination = ref({});
const columns = ref([]);
const rows = ref([]);
const itemDelete = ref(null);
const confirmRowDelete = ref(false);

const LABELS = {
  loading: 'Carregando...',
  noData: 'Nenhum registro encontrado',
  confirmDeleteTitle: 'Tem certeza que deseja excluir por definitivo este perfil?',
  yes: 'Sim',
  no: 'Não',
  details: 'Ver detalhes',
  edit: 'Editar',
  delete: 'Excluir',
};

const deleteRow = (row) => {
  confirmRowDelete.value = true;
  itemDelete.value = row;
};

const confirmDeleteRow = (isStatus) => {
  confirmRowDelete.value = false;
  if (isStatus) emit('onDelete', itemDelete.value);
  itemDelete.value = null;
};
</script>

<template>
  <q-table
    class="table-default-data-table"
    flat
    bordered
    :rows="rows"
    :columns="columns"
    row-key="id"
    :rows-per-page-options="[10, 25, 50, 100]"
    :loading="loading"
    :loading-label="LABELS.loading"
    :pagination="pagination"
    :no-data-label="loading ? '' : LABELS.noData"
    @update:pagination="emit('updatePagination', $event)"
    @request="emit('updatePagination', $event)">
    <template #header="props">
      <q-dialog v-model="confirmRowDelete" persistent>
        <q-card>
          <q-card-section class="confirm-dialog-title">
            <span
              ><strong>{{ LABELS.confirmDeleteTitle }}</strong></span
            >
          </q-card-section>
          <q-card-actions align="center" class="confirm-dialog-actions">
            <q-btn
              v-close-popup
              outline
              :label="LABELS.yes"
              color="primary"
              @click="confirmDeleteRow(true)" />
            <q-btn
              v-close-popup
              :label="LABELS.no"
              color="primary"
              @click="confirmDeleteRow(false)" />
          </q-card-actions>
        </q-card>
      </q-dialog>

      <q-tr :props="props">
        <q-th v-for="col in props.cols" :key="col.name" :props="props">
          {{ col.label }}
        </q-th>
      </q-tr>
    </template>

    <template #body="props">
      <q-tr :props="props">
        <q-td v-for="col in props.cols" :key="col.name" :props="props">
          <div v-if="col.name === 'action'" class="actions-container">
            <q-btn
              dense
              flat
              round
              color="primary"
              icon="visibility"
              @click="emit('onConsult', props.row)"
              :title="LABELS.details"
              v-if="col.methods?.onConsult" />
            <q-btn
              dense
              flat
              round
              color="primary"
              icon="edit"
              @click="emit('onEdit', props.row)"
              :title="LABELS.edit"
              v-if="!shouldBlockEditRoleAdmin(props.row.slug) && col.methods?.onEdit" />
            <q-btn
              dense
              flat
              round
              color="negative"
              icon="delete"
              @click="deleteRow(props.row)"
              :title="LABELS.delete"
              v-if="
                !shouldBlockDeleteProtectedRole(props.row.slug) &&
                shouldBlockDeleteRoleUserAuth(props.row.id) &&
                col.methods?.onDelete
              " />
          </div>
          <span v-else>
            {{ props.row[col.field] ?? '-' }}
          </span>
        </q-td>
      </q-tr>
    </template>

    <template #pagination="scope">
      <Pagination :scope="scope" />
    </template>
  </q-table>
</template>

<style lang="sass" scoped>
.table-default-data-table
  .q-table__top,
  thead tr:first-child th
    background-color: #064C7E
    color: #ffffff
    font-weight: bold
  thead tr th
    position: sticky
    z-index: 1
  thead tr:first-child th
    top: 0

.actions-container
  display: flex
  justify-content: center
  align-items: center
  gap: 8px

.confirm-dialog-title
  display: flex
  justify-content: center
  align-items: center
  text-align: center
  padding: 16px

.confirm-dialog-actions
  display: flex
  justify-content: center
  gap: 12px

.q-btn
  transition: transform 0.15s ease
  &:hover
    transform: scale(1.1)
</style>
