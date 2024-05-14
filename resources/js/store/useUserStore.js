import { defineStore } from 'pinia';
import service from '@/services/UserService';

const useUserStore = defineStore('users', {
  state: () => ({
    users: [],
    user: null,
    errors: null,
  }),
  getters: {
    getUsers() {
      return this.users;
    },
    getUser() {
      return this.user;
    },
    getErrors() {
      return this.errors;
    },
  },
  actions: {
    async list(params) {
      const data = await service.index(params);
      this.users = data;
    },
    async consult(id) {
      const { data } = await service.get(id);
      this.user = data;
    },
    async store(params) {
      try {
        this.errors = null;
        return await service.store(params);
      } catch (error) {
        this.errors = error.response.data.errors;
        throw error;
      }
    },
    async update(id, params) {
      try {
        this.errors = null;
        const response = await service.update(id, params);
        this.user = response.data;
        return this.user;
      } catch (error) {
        this.errors = error.response.data.errors;
        throw error;
      }
    },

    async destroy(id) {
      await service.destroy(id);
    },

    async register(params) {
      try {
        this.errors = null;
        return await service.register(params);
      } catch (error) {
        this.errors = error.response.data.errors;
        throw error;
      }
    },

    async verifyEmail(params) {
      return await service.verifyEmail(params);
    },
  },
});

export default useUserStore;
