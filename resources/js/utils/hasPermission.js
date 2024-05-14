import useAuthStore from '@/store/useAuthStore';

function hasPermission(permissions) {
  const authStore = useAuthStore();

  if (typeof permissions == 'string') {
    permissions = permissions.split('|');
  }

  return !!authStore.getPermissions?.find(({ name }) => permissions.includes(name));
}

export { hasPermission };
