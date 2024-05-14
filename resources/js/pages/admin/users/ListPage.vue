<script setup>
import { ref } from 'vue';
import TableSync from '@/components/users/TableSync.vue';
import useUserStore from '@/store/useUserStore';
import { useRouter } from 'vue-router';
import useAuthStore from '@/store/useAuthStore';
import { Notify, useQuasar } from 'quasar';
import { hasPermission } from '@utils/hasPermission';
import { USER_PERMISSION } from '@utils/permissions';

const store = useUserStore();
const router = useRouter();
const $q = useQuasar();

const filter = ref('');
const searchText = ref('');
const loading = ref(false);
const pagination = ref({});
const confirmHandleStatus = ref(false);
const rows = ref([]);
const dataHandleStatus = ref(null);
const authStore = useAuthStore();

const columns = ref([
  { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true },
  {
    name: 'name',
    required: true,
    label: 'Nome',
    align: 'left',
    field: 'name',
    format: (val) => `${val}`,
    sortable: true,
  },
  {
    name: 'email',
    label: 'E-mail',
    field: 'email',
    align: 'left',
    sortable: true,
  },
  {
    name: 'role',
    label: 'Perfil',
    align: 'left',
    field: 'role',
    sortable: true,
  },
  {
    name: 'setSituation',
    required: true,
    label: 'Situação',
    align: 'left',
    field: (row) => row.active,
    format: (val) => `${val}`,
  },
  {
    name: 'action',
    label: 'Opções',
    align: 'center',
    field: (row) => row.id,
    format: (val) => `${val}`,
  },
]);

const listPage = async (params = {}) => {
  try {
    $q.loading.show();
    loading.value = true;
    params.search = searchText.value;
    await store.list(params);
    rows.value = store.getUsers.data.map((row) => ({
      ...row,
      methods: {
        onConsult: false,
        onEdit: hasPermission([USER_PERMISSION.EDIT]),
        onDelete: row.id !== authStore.user?.id && hasPermission([USER_PERMISSION.DELETE]),
      },
    }));

    pagination.value.rowsPerPage = store.getUsers.per_page;
    pagination.value.page = store.getUsers.current_page;
    pagination.value.rowsNumber = store.getUsers.total;
  } finally {
    loading.value = false;
    $q.loading.hide();
  }
};

const updatePagination = async (event) => {
  pagination.value.descending = event.pagination?.descending;
  pagination.value.sortBy = event.pagination?.sortBy;
  await listPage({
    limit: event.pagination?.rowsPerPage,
    page: event.pagination?.page,
    order:
      event.pagination?.descending || event?.pagination?.descending == undefined
        ? 'desc'
        : 'asc',
    column: event.pagination?.sortBy,
    search: '',
  });
};

const onStatus = async (event) => {
  const { id, name, email, cpf, active, role_id } = event.data;
  dataHandleStatus.value = {
    id,
    name,
    email,
    cpf,
    active: active ? 1 : 0,
    role_id,
  };

  confirmHandleStatus.value = Boolean(event.value);
  if (!event.value) {
    handleStatus(false);
  }
};

const handleStatus = async (isNotify) => {
  try {
    const { id } = dataHandleStatus.value;
    delete dataHandleStatus.value.id;
    await store.update(id, {
      ...dataHandleStatus.value,
      notify_status: isNotify,
    });

    Notify.create({
      position: 'top-right',
      color: 'positive',
      message: 'Status atualizado com sucesso!',
    });

    dataHandleStatus.value = null;
  } finally {
    await listPage({
      limit: pagination.value?.rowsPerPage,
      page: pagination.value?.page,
      order:
        pagination.value?.descending || pagination.value?.descending == undefined
          ? 'desc'
          : 'asc',
      column: pagination.value?.sortBy,
      search: '',
    });
  }
};

const handleSearch = async () => {
  searchText.value = filter.value;

  await listPage({
    limit: pagination.value?.rowsPerPage,
    order: pagination.value?.descending ? 'desc' : 'asc',
    column: pagination.value?.sortBy,
  });
};

const onEdit = (event) => {
  router.push({
    name: 'editUsers',
    params: {
      id: event.id,
    },
  });
};

const onDelete = async (payload) => {
  try {
    $q.loading.show();
    await store.destroy(payload);
    Notify.create({
      position: 'top-right',
      color: 'positive',
      message: 'Usuário removido com sucesso!',
    });
  } finally {
    $q.loading.hide();
    await listPage({
      limit: pagination.value?.rowsPerPage,
      page: pagination.value?.page,
      order: pagination.value?.descending ? 'desc' : 'asc',
      column: pagination.value?.sortBy,
      search: '',
    });
  }
};
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
