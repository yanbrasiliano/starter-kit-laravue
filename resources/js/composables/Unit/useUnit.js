import useUnitStore from '@/store/useUnitStore';
import { useQuasar } from 'quasar';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { Notify } from 'quasar';
import { hasPermission } from '@/utils/hasPermission';
import { UNIT_PERMISSION } from '../../utils/permissions';

const useUnit = () => {
  const store = useUnitStore();
  const router = useRouter();
  const $q = useQuasar();

  const loading = ref(false);
  const pagination = ref({});
  const searchText = ref('');
  const rows = ref([]);
  const filter = ref('');
  const unit = ref(null);
  const errors = ref([]);

  const columns = ref([
    { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true },
    {
      name: 'description',
      required: true,
      label: 'Descrição',
      align: 'left',
      field: 'description',
      sortable: true,
    },
    {
      name: 'acronym',
      label: 'Sigla',
      field: 'acronym',
      align: 'left',
      sortable: true,
    },
    {
      name: 'action',
      label: 'Opções',
      align: 'center',
      field: (row) => row.id,
      format: (val) => `${val}`,
      methods: {
        onConsult: false,
        onEdit: hasPermission([UNIT_PERMISSION.EDIT]),
        onDelete: hasPermission([UNIT_PERMISSION.DELETE]),
      },
    },
  ]);

  const onEdit = (event) => {
    router.push({
      name: 'editUnits',
      params: {
        id: event.id,
      },
    });
  };

  const listPage = async (params = {}) => {
    try {
      $q.loading.show();

      loading.value = true;
      params.search = searchText.value;
      await store.list(params);
      rows.value = store.getUnits.data;
      pagination.value.rowsPerPage = store.getUnits.per_page;
      pagination.value.page = store.getUnits.current_page;
      pagination.value.rowsNumber = store.getUnits.total;
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

  const handleSearch = async () => {
    searchText.value = filter.value;
    await listPage({
      limit: pagination.value?.rowsPerPage,
      order:
        pagination.value?.descending || pagination.value?.descending == undefined
          ? 'desc'
          : 'asc',
      column: pagination.value?.sortBy,
    });
  };

  const onDelete = async (event) => {
    try {
      $q.loading.show();
      await store.destroy(event.id);
      Notify.create({
        position: 'top-right',
        color: 'positive',
        message: 'Unidade removida com sucesso!',
      });
    } finally {
      $q.loading.hide();
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

  const sendUnit = async (payload) => {
    try {
      let action = 'cadastrada';
      loading.value = true;
      const { id, ...params } = payload;

      if (id) {
        action = 'atualizada';
        await store.update(id, params);
      } else {
        await store.store(params);
      }
      Notify.create({
        position: 'top-right',
        color: 'positive',
        message: `Unidade ${action} com sucesso!`,
      });
      router.push({ name: 'listUnits' });
    } finally {
      loading.value = false;
      errors.value = store.getErrors;
    }
  };

  const get = async (id) => {
    try {
      $q.loading.show();
      await store.consult(id);
      unit.value = store.getUnit;
    } finally {
      $q.loading.hide();
    }
  };

  return {
    onEdit,
    listPage,
    updatePagination,
    handleSearch,
    onDelete,
    sendUnit,
    get,
    loading,
    pagination,
    rows,
    filter,
    unit,
    columns,
    router,
    errors,
  };
};

export default useUnit;
