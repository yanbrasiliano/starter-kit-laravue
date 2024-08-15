<script setup>
import { ref, watch } from 'vue';
import DeletionConfirmation from '@/components/users/modal/DeletionConfirmation.vue';

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
const loading = ref();
const pagination = ref({});
const columns = ref();
const rows = ref();
const deletionReason = ref('');
const itemDelete = ref(null);
const confirmRowDelete = ref(false);

const props = defineProps({
  modelValue: Boolean,
});

const show = ref(props.modelValue);

watch(
  () => props.modelValue,
  (newValue) => {
    show.value = newValue;
  },
);

const confirmDeletion = (payload) => {
  try {
    emit('onDelete', payload);
  } finally {
    confirmRowDelete.value = false;
  }
};

const deleteRow = (row) => {
  itemDelete.value = row;
  confirmRowDelete.value = true;
};

const cancelDeletion = () => {
  emit('cancel');
  show.value = false;
  deletionReason.value = '';
  confirmRowDelete.value = false;
};
</script>

<template>
  <q-table
    class="table-default-data-table"
    :rows="rows"
    :columns="columns"
    row-key="name"
    no-data-label="Nenhum registro encontrado"
    :rows-per-page-options="[10, 25, 50, 100]"
    :loading="loading"
    loading-label="Carregando..."
    :pagination="pagination"
    :computed-rows-number="20"
    @update:pagination="emit('updatePagination', $event)"
    @request="emit('updatePagination', $event)">
    <template #header="headerProps">
      <DeletionConfirmation
        v-model="confirmRowDelete"
        :item="itemDelete"
        @confirm="confirmDeletion"
        @cancel="cancelDeletion" />
      <q-tr :props="headerProps">
        <q-th v-for="col in headerProps.cols" :key="col.name" :props="headerProps">
          {{ col.label }}
        </q-th>
      </q-tr>
    </template>

    <template #body="bodyProps">
      <q-tr :props="bodyProps">
        <q-td v-for="col in bodyProps.cols" :key="col.name" :props="bodyProps">
          <span v-if="col.name == 'setSituation'">
            <q-toggle
              v-model="bodyProps.row.active"
              color="primary"
              keep-color
              @update:model-value="
                emit('onStatus', { value: $event, data: bodyProps.row })
              " />
          </span>
          <span v-else-if="col.name == 'action'">
            <q-btn
              v-if="col.methods.onConsult"
              color="primary"
              dense
              flat
              icon="visibility"
              @click="emit('onConsult', bodyProps.row)">
              <q-tooltip>Visualizar</q-tooltip>
            </q-btn>
            <q-btn
              v-if="col.methods.onEdit"
              color="primary"
              dense
              flat
              icon="edit"
              @click="emit('onEdit', bodyProps.row)">
              <q-tooltip>Editar</q-tooltip>
            </q-btn>
            <q-btn
              v-if="col.methods.onDelete(bodyProps.row)"
              color="primary"
              flat
              dense
              icon="delete"
              @click="deleteRow(bodyProps.row)">
              <q-tooltip>Deletar</q-tooltip>
            </q-btn>
          </span>
          <span v-else>
            {{ col.value }}
          </span>
        </q-td>
      </q-tr>
    </template>

    <template #pagination="scope">
      <span>Página {{ scope.pagination.page }} de {{ scope.pagesNumber }} </span>
      <q-btn
        v-if="scope.pagesNumber > 2"
        icon="first_page"
        color="grey-8"
        round
        dense
        flat
        :disable="scope.isFirstPage"
        @click="scope.firstPage" />
      <q-btn
        icon="chevron_left"
        color="grey-8"
        round
        dense
        flat
        :disable="scope.isFirstPage"
        @click="scope.prevPage" />
      <q-btn
        icon="chevron_right"
        color="grey-8"
        round
        dense
        flat
        :disable="scope.isLastPage"
        @click="scope.nextPage" />
      <q-btn
        v-if="scope.pagesNumber > 2"
        icon="last_page"
        color="grey-8"
        round
        dense
        flat
        :disable="scope.isLastPage"
        @click="scope.lastPage" />
    </template>
  </q-table>
</template>

<style lang="sass">
.table-default-data-table
  .q-table__top,
  thead tr:first-child th
    background-color: #064C7E
    color: white
    font-weight: bold

  thead tr th
    position: sticky
    z-index: 1
  thead tr:first-child th
    top: 0
</style>
