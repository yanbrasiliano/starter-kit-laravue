<script setup>
import Pagination from '@/components/shared/Pagination.vue';

const emit = defineEmits(['updatePagination', 'onConsult', 'onEdit', 'onDelete']);

const props = defineProps({
  loading: Boolean,
  pagination: Object,
  columns: Array,
  rows: Array,
});

const LABELS = {
  loading: 'Carregando...',
  noData: 'Nenhum registro encontrado',
  details: 'Ver detalhes',
  edit: 'Editar',
  delete: 'Excluir',
  actionsMinWidth: '120px',
  headerBg: '#064C7E',
  headerColor: '#ffffff',
};
</script>

<template>
  <q-table
    class="table-default-data-table"
    flat
    bordered
    :rows="props.rows ?? []"
    :columns="props.columns ?? []"
    row-key="id"
    :rows-per-page-options="[10, 25, 50, 100]"
    :loading="props.loading"
    :loading-label="LABELS.loading"
    :pagination="props.pagination"
    :no-data-label="props.loading ? '' : LABELS.noData"
    @update:pagination="emit('updatePagination', $event)"
    @request="emit('updatePagination', $event)">
    <template #header="props">
      <q-tr :props="props">
        <q-th v-for="col in props.cols" :key="col.name" :props="props">
          {{ col.label }}
        </q-th>
      </q-tr>
    </template>

    <template #body="bodyProps">
      <q-tr :props="bodyProps">
        <q-td v-for="col in bodyProps.cols" :key="col.name" :props="bodyProps">
          <div v-if="col.name === 'action'" class="actions-container">
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
              color="warning"
              icon="edit"
              @click="emit('onEdit', bodyProps.row)"
              :title="LABELS.edit" />
            <q-btn
              v-if="col.methods?.onDelete"
              dense
              flat
              round
              color="negative"
              icon="delete"
              @click="emit('onDelete', bodyProps.row)"
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
    background-color: v-bind('LABELS.headerBg')
    color: v-bind('LABELS.headerColor')
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
  min-width: v-bind('LABELS.actionsMinWidth')

.q-btn
  transition: transform 0.15s ease
  &:hover
    transform: scale(1.1)
</style>
