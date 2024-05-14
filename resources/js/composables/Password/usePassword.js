import usePasswordStore from '@/store/usePasswordStore';

const usePassword = () => {
  const store = usePasswordStore();

  const requestPasswordRecovery = async (formData) => {
    await store.requestPasswordRecovery(formData);
  };

  const send = async (credentials) => {
    await store.sendPasswordReset(credentials);
  };

  return { send, requestPasswordRecovery };
};

export default usePassword;
