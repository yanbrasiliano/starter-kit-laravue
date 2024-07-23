import { defineStore, storeToRefs } from 'pinia';
import roleService from '@/services/RoleService';
import { format } from 'date-fns';
import useUserStore from '@/store/useUserStore';
import useAuthStore from '@/store/useAuthStore';
import { ref } from 'vue';

const { user } = storeToRefs(useAuthStore());
const store = useUserStore();
const userAuth = ref();

const useRoleStore = defineStore('roles', {
  state: () => ({
    roles: [],
    rolesAll: [],
    role: {
      name: '',
      description: '',
      permissions: [],
    },
    pagination: {
      page: 1,
      rowsPerPage: 10,
      rowsNumber: 0,
      sortBy: 'id',
      descending: true,
      sortOrder: 'asc',
      search: '',
    },
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
    async fetchRoles(params) {
      this.loading = true;
      try {
        const { pagination, roles } = await roleService.index(params);
        this.roles = roles;
        this.pagination = pagination;
      } catch (error) {
        console.error('Failed to fetch roles:', error);
      } finally {
        this.loading = false;
      }
    },

    async fetchById(id) {
      this.loading = true;
      try {
        const { role } = await roleService.get(id);
        this.role = role;
      } catch (error) {
        console.error('Failed to fetch role:', error);
      } finally {
        this.loading = false;
      }
    },

    async shouldBlockEditRoleAdmin(idRoleRow) {
      if (userAuth.value === undefined) {
        await store.consult(user.value.id);
        userAuth.value = store.getUser;
      }
      return idRoleRow == 1 ? !userAuth.value?.roles.find(({ id }) => id == 1) : true;
    },

    async shouldBlockDeleteRoleUserAuth(idRoleRow) {
      if (userAuth.value === undefined) {
        await store.consult(user.value.id);
        userAuth.value = store.getUser;
      }
      return !userAuth.value?.roles.find(({ id }) => id == idRoleRow);
    },

    async store(params) {
      this.loading = true;
      this.message = null;
      try {
        const { data, status } = await roleService.store(params);
        this.message =
          status === 200 ? data?.message || 'Perfil criado com sucesso!' : null;
        this.isSuccess = status === 200;
      } catch (error) {
        this.isSuccess = false;
        this.errors = error.response?.data?.errors;
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async update(id, params) {
      this.loading = true;
      try {
        const { data, status } = await roleService.update(id, params);
        this.message =
          status === 200 ? data.message || 'Perfil atualizado com sucesso!' : null;
        this.isSuccess = status === 200;
      } catch (error) {
        this.isSuccess = false;
        this.errors = error.response?.data?.errors;
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async destroy(id) {
      try {
        await roleService.destroy(id);
      } catch (error) {
        console.error('Failed to delete role:', error);
      }
    },

    async listAll() {
      try {
        const data = await roleService.listAll();
        this.rolesAll = data;
      } catch (error) {
        console.error('Failed to list all roles:', error);
      }
    },

    resetStore() {
      this.role = {
        name: '',
        description: '',
        permissions: [],
      };
      this.isSuccess = false;
      this.message = null;
      this.errors = null;
    },
  },
});

export default useRoleStore;
