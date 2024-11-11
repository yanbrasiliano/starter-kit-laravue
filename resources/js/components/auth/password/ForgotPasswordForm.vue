<script setup>
import { ref } from 'vue';
import notify from '@/utils/notify';
import usePassword from '@/composables/Authenticate/usePassword';
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

    notify('Email enviado com sucesso');
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
      class="input-color-blue"
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
