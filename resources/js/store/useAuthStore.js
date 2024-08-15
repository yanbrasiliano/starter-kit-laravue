import { defineStore } from 'pinia';
import { LocalStorage } from 'quasar';
import { myProfile } from '@/services/AuthenticateService';
import UserService from '@/services/UserService';

const useAuthStore = defineStore('auth', {
  state: () => ({
    permissions: null,
    roles: null,
    contributor: null,

    users: [],
    user: null,
    errors: null,
  }),
  persist: {
    key: 'auth',
    storage: localStorage,
  },
  getters: {
    isUserLoggedIn(state) {
      return Boolean(state.user);
    },
    getPermissions() {
      return this.permissions;
    },
    getRoles() {
      return this.roles;
    },
    getUsers() {
      return this.users;
    },
    getUser() {
      return this.user ?? JSON.parse(localStorage.getItem('auth'))?.user;
    },
    getErrors() {
      return this.errors;
    },
  },
  actions: {
    async list(params) {
      const data = await UserService.index(params);
      this.users = data;
    },
    setCredentials({ user }) {
      this.user = {
        id: user.id,
        name: user.name,
        email: user.email,
      };
    },
    logout() {
      this.$reset();
      LocalStorage.clear();
      localStorage.clear();
    },
    async setProfile() {
      const { data } = await myProfile();
      this.permissions = data?.permissions;
      this.roles = data?.roles;
      this.contributor = data?.contributor;
    },
  },
});

export default useAuthStore;
