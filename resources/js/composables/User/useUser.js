import useAuthStore from '@/store/useAuthStore';
import useUserStore from '@/store/useUserStore';
import notify from '@/utils/notify';
import { storeToRefs } from 'pinia';
import { useQuasar } from 'quasar';
import { computed, ref } from 'vue';
import { useRouter } from 'vue-router';

const useUser = () => {
  const $q = useQuasar();
  const router = useRouter();
  const store = useUserStore();
  const loading = ref(false);
  const pagination = ref({});
  const searchText = ref('');
  const rows = ref([]);

  const { user } = storeToRefs(useAuthStore());

  const filter = ref(null);
  const errors = ref(null);

  const confirmHandleStatus = ref(false);
  const dataHandleStatus = ref(null);

  const nameUser = computed(() => {
    return user.value?.name;
  });

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

  const listPage = async (params = {}) => {
    try {
      $q.loading.show();
      loading.value = true;
      params.search = searchText.value;
      await store.list(params);
      rows.value = store.getUsers.data;
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

  const onRegister = async (payload) => {
    const { role, ...params } = payload;
    try {
      loading.value = true;
      await store.register({ ...params, role: role.value });

      notify('Cadastro realizado com sucesso! Um e-mail de confirmação foi encaminhado.');
      router.push({ name: 'login' });
    } finally {
      loading.value = false;
      errors.value = store.getErrors;
    }
  };

  const onVerifyEmail = async (params) => {
    try {
      await store.verifyEmail(params);

      notify('Confirmação de cadastro realizada com sucesso');
    } finally {
      router.push({ name: 'login' });
    }
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

      notify('Status atualizado com sucesso');

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

  const onEdit = (event) => {
    router.push({
      name: 'editUsers',
      params: {
        id: event.id,
      },
    });
  };

  const onDelete = async (event) => {
    try {
      $q.loading.show();
      await store.destroy(event.id);

      notify('Usuário removido com sucesso');
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

  return {
    router,
    filter,
    handleSearch,
    onEdit,
    onDelete,
    loading,
    rows,
    pagination,
    updatePagination,
    onStatus,
    confirmHandleStatus,
    handleStatus,
    onRegister,
    onVerifyEmail,
    nameUser,
  };
};

export default useUser;
