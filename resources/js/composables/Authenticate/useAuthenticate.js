import { Notify } from 'quasar';
import useAuthStore from '@/store/useAuthStore';
import { authenticate, unauthenticate } from '@/services/AuthenticateService';

const useAuthenticate = () => {
  const authStore = useAuthStore();
  const login = async (credentials) => {
    const response = await authenticate(credentials);
    const { user, access_token } = response.data;
    authStore.setCredentials({ user, token: access_token });
    return response;
  };

  const logout = async () => {
    const response = await unauthenticate();
    const message = response.data.message || 'Logout efetuado com sucesso!';
    Notify.create({
      position: 'top-right',
      color: 'positive',
      message: message,
    });

    authStore.logout();
    window.location.replace('/');
  };

  const myProfile = async () => {
    await authStore.setProfile();
  };
  return { login, logout, myProfile };
};

export default useAuthenticate;
