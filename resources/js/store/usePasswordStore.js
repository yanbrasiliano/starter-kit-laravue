import { defineStore } from 'pinia';
import PasswordService from '@/services/PasswordService';

const usePasswordStore = defineStore('password', {
  state: () => ({}),
  persist: {},
  getters: {},
  actions: {
    async sendPasswordReset(params) {
      await PasswordService.resetPassword(params);
    },

    async requestPasswordRecovery(params) {
      await PasswordService.requestPasswordRecovery(params);
    },
  },
});

export default usePasswordStore;
