<script setup>
import { ref, defineEmits, watch } from 'vue';
import DeletionConfirmation from '@/components/users/modal/DeletionConfirmation.vue';

const props = defineProps({
  modelValue: Boolean,
  rows: Array,
  columns: Array,
});

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
]);

const show = ref(props.modelValue);
const deletionReason = ref('');
const loading = ref(false);
const pagination = ref({});
const itemDelete = ref(null);
const confirmRowDelete = ref(false);

watch(
  () => props.modelValue,
  (newValue) => {
    show.value = newValue;
  },
);

const confirmDeletion = (payload) => {
  emit('onDelete', payload);
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
  <div>
    <DeletionConfirmation
      v-model="confirmRowDelete"
      :item="itemDelete"
      @confirm="confirmDeletion"
      @cancel="cancelDeletion" />
    <q-table
      class="table-default-data-table"
      :rows="props.rows"
      :columns="props.columns"
      row-key="name"
      no-data-label="Nenhum registro encontrado"
      :rows-per-page-options="[10, 25, 50, 100]"
      :loading="loading"
      loading-label="Carregando..."
      :pagination="pagination"
      :computed-rows-number="20"
      @update:pagination="emit('updatePagination', $event)"
      @request="emit('updatePagination', $event)">
      <template #header="propsData">
        <q-tr :props="propsData">
          <q-th v-for="col in propsData.cols" :key="col.name" :props="propsData">
            {{ col.label }}
          </q-th>
        </q-tr>
      </template>
      <template #body="propsData">
        <q-tr :props="propsData">
          <q-td v-for="col in propsData.cols" :key="col.name" :props="propsData">
            <span v-if="col.name == 'setSituation'">
              <q-toggle
                v-model="propsData.row.active"
                color="primary"
                keep-color
                @update:model-value="
                  emit('onStatus', { value: $event, data: propsData.row })
                " />
            </span>
            <span v-else-if="col.name == 'action'">
              <q-btn
                v-if="propsData.row.methods.onConsult"
                color="primary"
                dense
                flat
                icon="visibility"
                @click="emit('onConsult', propsData.row)">
                <q-tooltip>Visualizar</q-tooltip>
              </q-btn>
              <q-btn
                v-if="propsData.row.methods.onEdit"
                color="primary"
                flat
                dense
                icon="edit"
                @click="emit('onEdit', propsData.row)">
                <q-tooltip>Editar</q-tooltip>
              </q-btn>
              <q-btn
                v-if="propsData.row.methods.onDelete"
                color="primary"
                flat
                dense
                icon="delete"
                @click="deleteRow(propsData.row)">
                <q-tooltip>Deletar</q-tooltip>
              </q-btn>
            </span>
            <span v-else>
              {{ propsData.row[col.field] || col.format?.(propsData.row[col.field]) }}
            </span>
          </q-td>
        </q-tr>
      </template>
      <template #pagination="scope">
        <span> Página {{ scope.pagination.page }} de {{ scope.pagesNumber }} </span>
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
  </div>
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
