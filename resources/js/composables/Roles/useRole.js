import useAuthStore from '@/store/useAuthStore';
import { storeToRefs } from 'pinia';
import useRoleStore from '@/store/useRoleStore';

const { role } = storeToRefs(useRoleStore());

const authStore = useAuthStore();
export default function useRole() {
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

  return { blockEditRoleAdmin, blockDeleteRoleUserAuth, blockSelectPermission };
}
