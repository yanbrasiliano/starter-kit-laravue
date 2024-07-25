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
    async fetchRoles(params) {
      try {
        this.loading = true;
        const { pagination, roles, status } = await roleService.index(params);
        if (status === 200) {
          this.roles = roles;
          this.pagination.rowsPerPage = pagination?.per_page;
          this.pagination.page = pagination?.current_page;
          this.pagination.rowsNumber = pagination?.total;
          this.pagination.descending = pagination?.descending;
        }
      } finally {
        this.loading = false;
      }
    },
    async fetchById(id) {
      try {
        this.loading = true;
        const { role, status } = await roleService.get(id);

        if (status === 200) {
          this.role = role;
        }
      } finally {
        this.loading = false;
      }
    },
    async shouldBlockEditRoleAdmin(idRoleRow) {
      if (userAuth.value === undefined) {
        await store.consult(user.value.id);
        userAuth.value = store.getUser;
      }
      if (idRoleRow == 1) {
        return !userAuth.value?.roles.find(({ id }) => id == 1);
      }
      return true;
    },
    async shouldBlockDeleteRoleUserAuth(idRoleRow) {
      if (userAuth.value === undefined) {
        await store.consult(user.value.id);
        userAuth.value = store.getUser;
      }
      return !userAuth.value?.roles.find(({ id }) => id == idRoleRow);
    },
    async store(params) {
      try {
        this.loading = true;
        this.message = null;

        const { data, status } = await roleService.store(params);
        if (status === 200) {
          this.message = data?.message || 'Perfil criado com sucesso!';
          this.isSuccess = true;
        }
      } catch (error) {
        this.isSuccess = false;
        this.errors = error.response.data.errors;
        throw error;
      } finally {
        this.loading = false;
      }
    },
    async update(id, params) {
      try {
        this.loading = true;

        const { data, status } = await roleService.update(id, params);
        if (status === 200) {
          this.message = data.message || 'Perfil atualizado com sucesso!';
          this.isSuccess = true;
        }
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
