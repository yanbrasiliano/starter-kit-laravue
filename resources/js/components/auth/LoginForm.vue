<script setup>
import { ref } from 'vue';
import { Notify } from 'quasar';
import useAuthenticate from '@/composables/Authenticate/useAuthenticate';
import { useRouter } from 'vue-router';

const credentials = ref({
  email: '',
  password: '',
  remember: false,
});
const { login } = useAuthenticate();
const router = useRouter();

const auth = async () => {
  await login({ ...credentials.value });
  Notify.create({
    position: 'top-right',
    color: 'positive',
    message: 'Logado com Sucesso',
    timeout: 1000,
  });
  router.push('/admin/inicio');
};
</script>
<template>
  <q-form @submit.prevent="auth">
    <q-input v-model="credentials.email" filled label="E-mail"> </q-input>
    <q-input v-model="credentials.password" filled label="Password" type="password">
    </q-input>
    <div class="row justify-between">
      <div class="col-md-4 flex flex-center">
        <RouterLink to="/esqueci-minha-senha" class="link" color="primary"
          >Forgot password?</RouterLink
        >
      </div>
    </div>
    <div class="q-mt-md">
      <q-btn label="Log In" type="submit" color="primary" class="full-width" />
    </div>
    <div class="row justify-between q-mt-md">
      <div class="col-md-12 flex">
        <span :style="{ color: '#718096', marginRight: '5px', fontSize: '15px' }">
          Don't have an account yet?
        </span>
        <RouterLink to="/cadastro" class="link" color="primary">Sign up</RouterLink>
      </div>
    </div>
  </q-form>
</template>

<style scoped>
.q-card {
  max-width: none;
  width: 100%;
}
.q-btn {
  width: 100%;
  margin-top: 20px;
}
.q-input {
  margin-bottom: 20px;
}
.link {
  text-decoration: none;
  color: #0a64b7;
}
</style>
