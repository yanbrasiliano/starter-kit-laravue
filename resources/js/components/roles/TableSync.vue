<script setup>
import { ref } from 'vue';
import useRole from '@/composables/Roles/useRole';

const { blockEditRoleAdmin, blockDeleteRoleUserAuth } = useRole();
const emit = defineEmits(['updatePagination', 'onConsult', 'onEdit', 'onDelete']);
const loading = ref();
const pagination = ref({});
const columns = ref();
const rows = ref();
const itemDelete = ref({});
const confirmRowDelete = ref(false);

const deleteRow = (row) => {
  confirmRowDelete.value = true;
  itemDelete.value = row;
};
const confirmDeleteRow = (isStatus) => {
  confirmRowDelete.value = false;
  if (isStatus) {
    emit('onDelete', itemDelete.value);
  }
  itemDelete.value = null;
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
    <template #header="props">
      <q-dialog v-model="confirmRowDelete" persistent>
        <q-card>
          <q-card-section class="row items-center">
            <span class="q-ml-sm"
              >Tem certeza que deseja excluir por definitivo este perfil?</span
            >
          </q-card-section>

          <q-card-actions align="center">
            <q-btn
              v-close-popup
              outline
              label="Sim"
              color="secondary"
              @click="confirmDeleteRow(true)" />
            <q-btn
              v-close-popup
              label="Não"
              color="secondary"
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
          <span v-if="col.name == 'action'">
            <q-btn
              v-if="col.methods.onConsult"
              color="primary"
              dense
              flat
              icon="visibility"
              :to="{ name: 'showRole', params: { id: props.row.id } }"
              @click="emit('onConsult', props.row)">
              <q-tooltip>Visualizar</q-tooltip>
            </q-btn>
            <q-btn
              v-if="blockEditRoleAdmin(props.row.id) && col.methods.onEdit"
              color="primary"
              flat
              dense
              icon="edit"
              @click="emit('onEdit', props.row)">
              <q-tooltip>Editar</q-tooltip>
            </q-btn>
            <q-btn
              v-if="
                !(props.row.id === 1) &&
                blockDeleteRoleUserAuth(props.row.id) &&
                col.methods.onDelete
              "
              color="primary"
              flat
              dense
              icon="delete"
              @click="deleteRow(props.row)">
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

<style lang="sass"></style>
