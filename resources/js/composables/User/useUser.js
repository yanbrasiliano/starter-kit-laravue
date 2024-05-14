import { ref } from 'vue';
import useUserStore from '@/store/useUserStore';
import { useRouter } from 'vue-router';
import { Notify } from 'quasar';

const useUser = () => {
  const store = useUserStore();
  const router = useRouter();

  const loading = ref(false);
  const errors = ref(null);

  const onRegister = async (payload) => {
    const { role, ...params } = payload;
    try {
      loading.value = true;
      await store.register({ ...params, role: role.value });
      Notify.create({
        position: 'top-right',
        color: 'positive',
        message: `Cadastro realizado com sucesso! Um e-mail de confirmação foi encaminhado.`,
      });
      router.push({ name: 'login' });
    } finally {
      loading.value = false;
      errors.value = store.getErrors;
    }
  };

  const onVerifyEmail = async (params) => {
    try {
      await store.verifyEmail(params);
      Notify.create({
        position: 'top-right',
        color: 'positive',
        message: `Confirmação de cadastro realizada com sucesso.`,
      });
    } finally {
      router.push({ name: 'login' });
    }
  };

  return { loading, errors, onRegister, onVerifyEmail };
};
export default useUser;
