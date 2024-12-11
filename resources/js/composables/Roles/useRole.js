import useAuthStore from '@/store/useAuthStore';
import useRoleStore from '@/store/useRoleStore';
import notify from '@/utils/notify';
import { storeToRefs } from 'pinia';
import { useQuasar } from 'quasar';
import { computed } from 'vue';
import { useRouter } from 'vue-router';

const useRole = () => {
  const $q = useQuasar();
  const router = useRouter();
  const { role, roles, pagination, loading } = storeToRefs(useRoleStore());
  const store = useRoleStore();
  const authStore = useAuthStore();

  const shouldBlockDeleteRoleUserAuth = computed(() => {
    return (idRoleRow) => !authStore.getRoles.find(({ id }) => id == idRoleRow);
  });
  const shouldBlockSelectPermission = computed(() => role.value?.id === 1);

  const shouldBlockEditRoleAdmin = (idRoleRow) => {
    return idRoleRow === 1;
  };
  async function updatePagination(event) {
    try {
      $q.loading.show();
      pagination.value.descending = event.pagination?.descending;
      pagination.value.sortBy = event.pagination?.sortBy;

      await store.fetchRoles({
        limit: event.pagination?.rowsPerPage,
        page: event.pagination?.page,
        order:
          event.pagination?.descending || event?.pagination?.descending == undefined
            ? 'desc'
            : 'asc',
        column: event.pagination?.sortBy,
      });
    } finally {
      $q.loading.hide();
    }
  }

  const onEdit = (event) => {
    router.push({
      name: 'editRoles',
      params: {
        id: event.id,
      },
    });
  };

  const onDelete = async (event) => {
    try {
      $q.loading.show();
      await store.destroy(event.id);

      notify('Perfil removido com sucesso');
    } finally {
      $q.loading.hide();

      await updatePagination({ ...{ pagination: pagination.value } });
    }
  };

  return {
    role,
    roles,
    pagination,
    loading,
    shouldBlockSelectPermission,
    shouldBlockDeleteRoleUserAuth,
    shouldBlockEditRoleAdmin,

    updatePagination,
    onEdit,
    onDelete,
  };
};

export default useRole;
