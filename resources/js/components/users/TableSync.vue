<script setup>
import Pagination from '@/components/shared/Pagination.vue';
import { ref } from 'vue';

const emit = defineEmits([
  'update:modelValue',
  'confirm',
  'cancel',
  'updatePagination',
  'onStatus',
  'onConsult',
  'onEdit',
  'onDelete',
  'notify',
  'onValidate',
]);

const loading = ref(false);
const pagination = ref({});
const columns = ref([]);
const rows = ref([]);
const itemDelete = ref(null);
const confirmRowDelete = ref(false);

const LABELS = {
  loading: 'Carregando...',
  noData: 'Nenhum registro encontrado',
  confirmDeleteTitle: 'Tem certeza de que deseja excluir este usuário?',
  confirmDeleteSubtitle: 'Esta ação não poderá ser desfeita.',
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
            <strong>{{ LABELS.confirmDeleteTitle }}</strong>
            <br />
            <span>{{ LABELS.confirmDeleteSubtitle }}</span>
          </q-card-section>
          <q-card-actions align="center" class="confirm-dialog-actions">
            <q-btn
              v-close-popup
              :label="LABELS.yes"
              color="primary"
              @click="confirmDeleteRow(true)" />
            <q-btn
              v-close-popup
              outline
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

    <template #body="bodyProps">
      <q-tr :props="bodyProps">
        <q-td v-for="col in bodyProps.cols" :key="col.name" :props="bodyProps">
          <span v-if="col.name === 'setSituation'">
            <q-toggle
              :model-value="!!bodyProps.row.active"
              color="primary"
              keep-color
              @update:model-value="
                emit('onStatus', { value: $event, data: bodyProps.row })
              " />
          </span>

          <div v-else-if="col.name === 'action'" class="actions-container">
            <q-btn
              v-if="col.methods?.onConsult"
              dense
              flat
              round
              color="primary"
              icon="visibility"
              @click="emit('onConsult', bodyProps.row)"
              :title="LABELS.details" />
            <q-btn
              v-if="col.methods?.onEdit"
              dense
              flat
              round
              color="primary"
              icon="edit"
              @click="emit('onEdit', bodyProps.row)"
              :title="LABELS.edit" />
            <q-btn
              v-if="col.methods?.onDelete(bodyProps.row)"
              dense
              flat
              round
              color="negative"
              icon="delete"
              @click="deleteRow(bodyProps.row)"
              :title="LABELS.delete" />
          </div>

          <span v-else>
            {{ bodyProps.row[col.field] ?? '-' }}
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
