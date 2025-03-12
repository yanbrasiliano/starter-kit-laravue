import useAuthStore from '@/store/useAuthStore';
import usePermissionStore from '@/store/usePermissionStore';
import useRoleStore from '@/store/useRoleStore';
import notify from '@/utils/notify';
import { storeToRefs } from 'pinia';
import { useQuasar } from 'quasar';
import { computed, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const useRole = () => {
  const $q = useQuasar();
  const router = useRouter();
  const route = useRoute();
  const { role, roles, pagination, loading, errors, message, isSuccess } =
    storeToRefs(useRoleStore());
  const roleStore = useRoleStore();
  const permissionStore = usePermissionStore();
  const authStore = useAuthStore();

  const selectedPermissionIds = ref([]);
  const initialRoleSetup = ref(false);

  watch(
    () => role.value,
    (newRole) => {
      if (!newRole || initialRoleSetup.value) return;

      const permissions = newRole.permissions || [];

      permissions.forEach((permission) => {
        const permissionId =
          typeof permission === 'object' ? permission.value : permission;

        if (
          typeof permissionId === 'number' &&
          !selectedPermissionIds.value.includes(permissionId)
        ) {
          selectedPermissionIds.value.push(permissionId);
        }
      });

      initialRoleSetup.value = true;
    },
    { immediate: true, deep: true },
  );

  const shouldBlockDeleteRoleUserAuth = computed(() => {
    return (idRoleRow) => !authStore.getRoles.find(({ id }) => id == idRoleRow);
  });

  const shouldBlockSelectPermission = computed(() => role.value?.id === 1);

  const isProtectedRole = (idRoleRow) => {
    return idRoleRow === 1 || idRoleRow === 2; // Admin (1) ou Visitante (2)
  };

  const shouldBlockEditRoleAdmin = (idRoleRow) => {
    return idRoleRow === 1;
  };

  const shouldBlockDeleteProtectedRole = (idRoleRow) => {
    return isProtectedRole(idRoleRow);
  };

  const togglePermission = (permissionId) => {
    if (shouldBlockSelectPermission.value) return;

    const index = selectedPermissionIds.value.indexOf(permissionId);

    index === -1
      ? selectedPermissionIds.value.push(permissionId)
      : selectedPermissionIds.value.splice(index, 1);
  };

  const saveRole = async () => {
    $q.loading.show();

    const params = {
      name: role.value?.name,
      description: role.value?.description,
      permissions: selectedPermissionIds.value.map((id) => ({ value: id })),
    };

    try {
      const hasId = Boolean(route.params.id);
      const action = hasId
        ? roleStore.update(route.params.id, params)
        : roleStore.store(params);

      await action;

      const color = isSuccess.value ? 'positive' : 'negative';
      $q.notify({ message: message.value, color, position: 'top-right' });

      isSuccess.value && router.push({ name: 'listRoles' });
    } catch (error) {
      console.error('Erro ao salvar perfil:', error);
    } finally {
      $q.loading.hide();
    }
  };

  const initializeRoleData = async () => {
    roleStore.resetStore();
    await permissionStore.fetchPermissions();
    initialRoleSetup.value = false;
  };

  const cleanupRoleData = () => {
    roleStore.resetStore();
    selectedPermissionIds.value = [];
    initialRoleSetup.value = false;
  };

  async function updatePagination(event) {
    try {
      $q.loading.show();
      pagination.value.descending = event.pagination?.descending;
      pagination.value.sortBy = event.pagination?.sortBy;

      await roleStore.fetchRoles({
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
      await roleStore.destroy(event.id);

      notify('Perfil excluído com sucesso!');
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
    errors,
    message,
    isSuccess,
    selectedPermissionIds,
    shouldBlockSelectPermission,
    shouldBlockDeleteRoleUserAuth,
    shouldBlockEditRoleAdmin,
    shouldBlockDeleteProtectedRole,
    togglePermission,
    saveRole,
    initializeRoleData,
    cleanupRoleData,
    updatePagination,
    onEdit,
    onDelete,
  };
};

export default useRole;
