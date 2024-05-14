<script setup>
import { onMounted, ref } from 'vue';
import { Notify } from 'quasar';
import usePassword from '@/composables/Password/usePassword';
import { useRoute, useRouter } from 'vue-router';

const loading = ref(false);

const credentials = ref({
  password: '',
  password_confirmation: '',
});
const { send } = usePassword();
const router = useRouter();
const route = useRoute();

onMounted(() => {
  const { token, email } = route.query;
  if (!token || token == '' || !email || email == '') {
    Notify.create({
      position: 'top-right',
      color: 'negative',
      message: 'Acesso Negado',
      timeout: 1000,
    });

    router.push({name: 'login'});
  }
});

const sendResetPassword = async () => {
  loading.value = true;
  try {
    const { token, email } = route.query;
    await send({ ...credentials.value, token, email });
    Notify.create({
      position: 'top-right',
      color: 'positive',
      message: 'Senha alterada com sucesso',
      timeout: 1000,
    });
    router.push('/');
  } finally {
    loading.value = false;
  }
};
</script>
<template>
  <q-form @submit.prevent="sendResetPassword">
    <q-input
      v-model="credentials.password"
      filled
      label="Nova senha"
      type="password"
      :rules="[
        (val) => (val && val.length > 0) || 'Por favor insira a sua nova senha',
        (val) => (val && val.length >= 8) || 'A senha deve conter no minimo 8 caracteres',
      ]">
    </q-input>
    <q-input
      v-model="credentials.password_confirmation"
      filled
      label="Confirmar senha"
      type="password"
      :rules="[
        (val) => (val && val.length > 0) || 'Por favor confirme a sua nova senha',
        (val) => (val && val.length >= 8) || 'A senha deve conter no minimo 8 caracteres',
        (val) => (val && val == credentials.password) || 'As senhas não conferem.',
      ]">
    </q-input>
    <div class="q-mt-md">
      <q-btn
        :loading="loading"
        label="Confirmar alteração"
        type="submit"
        color="secondary"
        class="full-width" />
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
</style>
