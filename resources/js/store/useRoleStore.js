import roleService from '@/services/RoleService';
import { format } from 'date-fns';
import { defineStore } from 'pinia';

const useRoleStore = defineStore('roles', {
  state: () => ({
    roles: [],
    rolesAll: [],
    role: {
      name: '',
      description: '',
      permissions: [],
    },
    pagination: {},
    loading: false,
    errors: null,
    message: null,
    params: null,
    isSuccess: false,
  }),
  getters: {
    getRolesRows() {
      return this.roles;
    },
    getAllRoles() {
      return this.rolesAll;
    },
    getPagination() {
      return this.pagination;
    },
    getRole() {
      return this.role;
    },
    getFormattedDate() {
      return this.role.createdAt ? format(this.role.createdAt, 'dd/MM/yyyy HH:mm') : '';
    },
  },
  actions: {
    async list(params) {
      try {
        const data = await roleService.index(params);
        this.roles = data;
      } catch (error) {
        this.isSuccess = false;
        this.errors = error.response.data.errors;
        throw error;
      } finally {
        this.loading = false;
      }
    },
    async fetchById(id) {
      this.loading = true;
      try {
        const { role, status } = await roleService.get(id);
        String(status).startsWith('2') && (this.role = role);
      } finally {
        this.loading = false;
      }
    },

    async store(params) {
      this.loading = true;
      this.message = null;

      try {
        const { data, status } = await roleService.store(params);
        this.isSuccess = String(status).startsWith('2');
        this.message = this.isSuccess && (data?.message ?? 'Perfil criado com sucesso');
      } catch (error) {
        this.isSuccess = false;
        this.errors = error.response.data.errors;
        throw error;
      } finally {
        this.loading = false;
      }
    },
    async update(id, params) {
      this.loading = true;

      try {
        const { data, status } = await roleService.update(id, params);
        this.isSuccess = String(status).startsWith('2');
        this.message =
          this.isSuccess && (data?.message ?? 'Perfil atualizado com sucesso');
      } catch (error) {
        this.isSuccess = false;
        this.errors = error.response.data.errors;
        throw error;
      } finally {
        this.loading = false;
      }
    },
    async destroy(id) {
      await roleService.destroy(id);
    },
    async listAll() {
      const data = await roleService.listAll();
      this.rolesAll = data;
    },
    resetStore() {
      this.role = { name: '', description: '', permissions: [] };
      this.isSuccess = this.message = this.errors = null;
    },
  },
});

export default useRoleStore;
