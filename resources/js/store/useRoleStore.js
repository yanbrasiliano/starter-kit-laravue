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
      this.loading = true;
      try {
        const { pagination, roles, status } = await roleService.index(params);
        String(status).startsWith('2') &&
          ((this.roles = roles),
          (this.pagination = {
            rowsPerPage: pagination?.per_page,
            page: pagination?.current_page,
            rowsNumber: pagination?.total,
          }));
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

    async shouldBlockEditRoleAdmin(idRoleRow) {
      userAuth.value =
        userAuth.value ?? (await store.consult(user.value.id), store.getUser);
      return idRoleRow == 1 ? !userAuth.value?.roles.some(({ id }) => id == 1) : true;
    },

    async shouldBlockDeleteRoleUserAuth(idRoleRow) {
      userAuth.value =
        userAuth.value ?? (await store.consult(user.value.id), store.getUser);
      return userAuth.value?.roles.some(({ id }) => id === idRoleRow) ? false : true;
    },
    async store(params) {
      this.loading = true;
      this.message = null;

      try {
        const { data, status } = await roleService.store(params);
        this.isSuccess = String(status).startsWith('2');
        this.message = this.isSuccess && (data?.message ?? 'Perfil criado com sucesso!');
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
          this.isSuccess && (data?.message ?? 'Perfil atualizado com sucesso!');
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
