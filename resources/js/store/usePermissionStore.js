import { defineStore } from 'pinia';
import permissionClient from '@/services/PermissionService';

const usePermissionStore = defineStore('permission', {
  state: () => ({
    permissions: [],
    permission: null,
  }),
  getters: {
    getPermissions() {
      return this.permissions;
    },
    getPermission() {
      return this.permission;
    },
  },
  actions: {
    async fetchPermissions() {
      const { data } = await permissionClient.index();

      this.permissions = data;
    },
  },
});

export default usePermissionStore;
