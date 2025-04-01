<script setup>
import useRole from '@/composables/Roles/useRole';
import { ref } from 'vue';

const {
  shouldBlockEditRoleAdmin,
  shouldBlockDeleteRoleUserAuth,
  shouldBlockDeleteProtectedRole,
} = useRole();
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
    flat
    bordered
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
          <q-btn
            v-if="col.name == 'action'"
            dense
            flat
            round
            icon="more_horiz"
            class="button-more-horiz"
          >
            <q-menu>
              <q-list dense style="min-width: 150px">
                <q-item
                  clickable
                  v-close-popup
                  :to="{ name: 'showRole', params: { id: props.row.id } }"
                  @click="emit('onConsult', props.row)"
                >
                  <q-item-section>Ver detalhes</q-item-section>
                </q-item>
                <q-item
                  v-if="!shouldBlockEditRoleAdmin(props.row.slug) && col.methods.onEdit"
                  clickable
                  v-close-popup
                  @click="emit('onEdit', props.row)"
                >
                  <q-item-section>Editar</q-item-section>
                </q-item>
                <q-separator></q-separator>
                <q-item 
                  v-if="
                    !shouldBlockDeleteProtectedRole(props.row.slug) &&
                    shouldBlockDeleteRoleUserAuth(props.row.id) &&
                    col.methods.onDelete
                  "
                  clickable 
                  v-close-popup 
                  @click="deleteRow(props.row)"
                >
                  <q-item-section>Excluir</q-item-section>
                </q-item>
              </q-list>
            </q-menu>
          </q-btn>
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

<style lang="sass" scoped>
:deep(.button-more-horiz i)
  font-size: 1.2rem !important

.q-list--dense > .q-item, .q-item--dense
  min-height: 38px
</style>
