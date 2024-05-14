import { defineStore } from 'pinia';
import { LocalStorage } from 'quasar';
import { myProfile } from '@/services/AuthenticateService';

const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    permissions: null,
    roles: null,
  }),
  persist: {
    key: 'auth',
    storage: localStorage,
  },
  getters: {
    getUser() {
      return this.user ?? JSON.parse(localStorage.getItem('auth'))?.user;
    },
    isUserLoggedIn(state) {
      return Boolean(state.user);
    },
    getPermissions() {
      return this.permissions;
    },
    getRoles() {
      return this.roles;
    },
  },
  actions: {
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
    },
  },
});

export default useAuthStore;
