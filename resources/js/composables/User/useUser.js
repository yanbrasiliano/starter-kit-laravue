import { ref } from 'vue';
import useUserStore from '@/store/useUserStore';
import { useRouter } from 'vue-router';
import { Notify, useQuasar } from 'quasar';
import { hasPermission } from '@/utils/hasPermission';
import { USER_PERMISSION } from '@/utils/permissions';
import useAuthStore from '@/store/useAuthStore.js';
const useUser = () => {
  const store = useUserStore();
  const router = useRouter();
  const $q = useQuasar();
  const authStore = useAuthStore();

  const loading = ref(false);
  const errors = ref(null);
  const pagination = ref({});
  const searchText = ref('');
  const rows = ref([]);
  const filter = ref('');
  const user = ref(null);

  const columns = ref([
    { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true },
    {
      name: 'name',
      required: true,
      label: 'Name',
      align: 'left',
      field: 'name',
      format: (val) => `${val}`,
      sortable: true,
    },
    {
      name: 'email',
      label: 'Email',
      field: 'email',
      align: 'left',
      sortable: true,
    },
    {
      name: 'role',
      label: 'Role',
      align: 'left',
      field: 'role',
      sortable: true,
    },
    {
      name: 'setSituation',
      required: true,
      label: 'Status',
      align: 'left',
      field: (row) => row.active,
      format: (val) => (val ? 'Active' : 'Inactive'),
    },
    {
      name: 'action',
      label: 'Actions',
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
          onDelete:
            row.id !== authStore.user?.id && hasPermission([USER_PERMISSION.DELETE]),
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
    pagination.value.descending = event.descending;
    pagination.value.sortBy = event.sortBy;
    await listPage({
      limit: event.rowsPerPage,
      page: event.page,
      order: event.descending ? 'desc' : 'asc',
      column: event.sortBy,
      search: '',
    });
  };

  const handleSearch = async () => {
    searchText.value = filter.value;
    await listPage({
      limit: pagination.value?.rowsPerPage,
      order:
        pagination.value?.descending || pagination.value?.descending === undefined
          ? 'desc'
          : 'asc',
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
        message: 'User successfully removed!',
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

  const onRegister = async (payload) => {
    const { role, ...params } = payload;
    try {
      loading.value = true;
      await store.register({ ...params, role: role.value });
      Notify.create({
        position: 'top-right',
        color: 'positive',
        message: `Cadastro realizado com sucesso! Um e-mail de confirmação foi encaminhado.`,
      });
      router.push({ name: 'login' });
    } finally {
      loading.value = false;
      errors.value = store.getErrors;
    }
  };

  const onVerifyEmail = async (params) => {
    try {
      await store.verifyEmail(params);
      Notify.create({
        position: 'top-right',
        color: 'positive',
        message: `Confirmação de cadastro realizada com sucesso.`,
      });
    } finally {
      router.push({ name: 'login' });
    }
  };

  return {
    loading,
    errors,
    pagination,
    searchText,
    rows,
    filter,
    user,
    columns,
    listPage,
    updatePagination,
    handleSearch,
    onEdit,
    onDelete,
    onRegister,
    onVerifyEmail,
  };
};

export default useUser;
