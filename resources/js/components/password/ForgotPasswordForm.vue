<script setup>
import { ref } from 'vue';
import { Notify } from 'quasar';
import usePassword from '@/composables/Password/usePassword';
import { useRouter } from 'vue-router';

const loading = ref(false);

const formData = ref({
  email: '',
});
const { requestPasswordRecovery } = usePassword();
const router = useRouter();

const sendResetPassword = async () => {
  loading.value = true;
  try {
    await requestPasswordRecovery(formData.value);
    Notify.create({
      position: 'top-right',
      color: 'positive',
      message: 'Solicitação de recuperação de senha enviada! Verifique o seu e-mail.',
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
      v-model="formData.email"
      filled
      label="E-mail"
      type="email"
      :rules="[(val) => (val && val.length > 0) || 'Por favor insira o e-mail']">
    </q-input>

    <div class="q-mt-md">
      <q-btn
        :loading="loading"
        label="Enviar"
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
