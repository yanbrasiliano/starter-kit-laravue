import { authenticate, unauthenticate } from '@/services/AuthenticateService';
import useAuthStore from '@/store/useAuthStore';
import { Notify } from 'quasar';

const useAuthenticate = () => {
  const authStore = useAuthStore();
  const login = async (credentials) => {
    const response = await authenticate(credentials);
    const { user, access_token: token } = response.data;
    authStore.setCredentials({ user, token });
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
