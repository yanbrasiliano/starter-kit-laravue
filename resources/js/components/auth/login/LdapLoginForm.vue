<script setup>
import { ref } from 'vue';
import notify from '@/utils/notify';
import useLDAPAuthenticate from '@/composables/Authenticate/useLDAPAuthenticate';
import useAuthenticate from '@/composables/Authenticate/useAuthenticate';
import { useRoute, useRouter } from 'vue-router';
import useAuthStore from '@/store/useAuthStore';

const authStore = useAuthStore();

const showPassword = ref(false);

const { myProfile } = useAuthenticate();
const { ldapLogin } = useLDAPAuthenticate();
const router = useRouter();
const route = useRoute();

const auth = async () => {
  await ldapLogin({ ...authStore.ldapCredentials });
  await myProfile();

  notify('Logado com Sucesso', 'positive');

  const { routeName, id } = route.query || {};
  router.push(routeName && id ? { name: routeName, params: { id } } : '/admin/inicio');
};

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};
</script>

<template>
  <q-form @submit.prevent="auth">
    <span class="text-weight-medium text--font-13">Domínio ou e-mail institucional</span>
    <q-input
      v-model="authStore.ldapCredentials.name"
      class="input-color-blue input--margin-bottom"
      filled
      placeholder="Insira seu domínio ou e-mail institucional">
    </q-input>

    <span class="text-weight-medium text--font-13">Senha</span>
    <q-input
      v-model="authStore.ldapCredentials.password"
      class="input-color-blue input--margin-bottom"
      filled
      :type="showPassword ? 'text' : 'password'"
      placeholder="Digite sua senha">
      <template #append>
        <q-icon
          :name="showPassword ? 'visibility_off' : 'visibility'"
          class="cursor-pointer"
          @click="togglePasswordVisibility" />
      </template>
    </q-input>
    <div class="row justify-between">
      <div class="col-md-4">
        <q-checkbox
          v-model="authStore.ldapCredentials.remember"
          class="text--font-13"
          label="Lembre-me" />
      </div>
      <div class="col-md-4 flex flex-center">
        <a
          target="_blank"
          href="https://cdu.uefs.br/app/password/reset"
          class="text-primary text--font-13"
          style="text-decoration: none"
          >Esqueceu a senha?</a
        >
      </div>
    </div>
    <div class="q-mt-xs">
      <q-btn label="Entrar" type="submit" color="secondary" class="full-width" />
    </div>
  </q-form>
</template>
