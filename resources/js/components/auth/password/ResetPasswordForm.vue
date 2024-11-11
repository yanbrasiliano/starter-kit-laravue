<script setup>
import { onMounted, ref } from 'vue';
import notify from '@utils/notify';
import usePassword from '@/composables/Authenticate/usePassword';
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
    notify('Acesso Negado', 'negative');

    router.push({ name: 'login' });
  }
});

const sendResetPassword = async () => {
  loading.value = true;
  try {
    const { token, email } = route.query;
    await send({ ...credentials.value, token, email });

    notify('Senha alterada com sucesso');
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
      class="input-color-blue"
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
      class="input-color-blue"
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
