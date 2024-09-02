import useAuthStore from '@/store/useAuthStore';
import { storeToRefs } from 'pinia';
import useRoleStore from '@/store/useRoleStore';
import { useQuasar } from 'quasar';
import notify from '@/utils/notify';
import { useRouter } from 'vue-router';

const useRole = () => {
  const $q = useQuasar();
  const router = useRouter();
  const { role, roles, pagination, loading } = storeToRefs(useRoleStore());
  const store = useRoleStore();

  const authStore = useAuthStore();

  const blockEditRoleAdmin = (idRoleRow) => {
    return (
      (idRoleRow == 1 && authStore.getRoles.find(({ id }) => id == 1)) || idRoleRow !== 1
    );
  };
  const blockDeleteRoleUserAuth = (idRoleRow) => {
    return !authStore.getRoles.find(({ id }) => id == idRoleRow);
  };
  const blockSelectPermission = () => {
    const hasNoPermissions = role.value?.permissions === null;
    const isPermissionsValueNull = role.value?.permissions?.[0]?.value === null;
    return hasNoPermissions || isPermissionsValueNull;
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

      notify('Perfil removido com sucesso!');
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
    blockEditRoleAdmin,
    blockDeleteRoleUserAuth,
    blockSelectPermission,
    updatePagination,
    onEdit,
    onDelete,
  };
};

export default useRole;
