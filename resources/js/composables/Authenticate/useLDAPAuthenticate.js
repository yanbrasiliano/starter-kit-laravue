import useAuthStore from '@/store/useAuthStore';
import { ldapAuthenticate } from '@/services/LdapLoginService';

const useLDAPAuthenticate = () => {
  const authStore = useAuthStore();

  const ldapLogin = async (credentials) => {
    const response = await ldapAuthenticate(credentials);
    const { user, access_token } = response.data;
    authStore.setCredentials({ user, token: access_token });
    return response;
  };

  return { ldapLogin };
};

export default useLDAPAuthenticate;
