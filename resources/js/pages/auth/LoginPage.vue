<script setup>
import AuthComponent from '@/components/AuthComponent.vue';
import LoginForm from '@/components/auth/login/LoginForm.vue';
import LdapLoginForm from '@/components/auth/login/LdapLoginForm.vue';
import useAuthStore from '@/store/useAuthStore';
import { watch } from 'vue';

const authStore = useAuthStore();

watch(
  () => authStore.activeTab,
  () => authStore.clearCredentialsOnTabChange(),
);
</script>

<template>
  <AuthComponent>
    <q-tabs
      v-model="authStore.activeTab"
      indicator-color="secondary"
      active-color="black"
      text-color="black">
      <q-tab name="ldap" label="Login Institucional" />
      <q-tab name="external" label="Login Público Externo" />
    </q-tabs>

    <q-tab-panels v-model="authStore.activeTab" animated>
      <q-tab-panel name="ldap">
        <LdapLoginForm />
      </q-tab-panel>
      <q-tab-panel name="external">
        <LoginForm />
      </q-tab-panel>
    </q-tab-panels>
  </AuthComponent>
</template>
