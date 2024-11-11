import axios from 'axios';
import { Loading } from 'quasar';
import useAuthStore from '@/store/useAuthStore';
import router from '@/routes';
import notify from '@/utils/notify';

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

const http = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  timeout: 1000000,
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'Content-Type': 'application/json',
  },
});

http.interceptors.response.use(
  (response) => response,
  async (error) => {
    Loading.hide();

    if (!error.response) {
      notify('Ocorreu um erro de rede inesperado.', 'negative');
      return Promise.reject(error);
    }

    const timeoutMessage =
      'Não foi possível carregar esta página corretamente, verifique sua conexão com a internet e tente novamente';
    if (error.code === 'ECONNABORTED') {
      notify(timeoutMessage, 'negative');
      return Promise.reject({ message: timeoutMessage });
    }

    let { status, data } = error.response;
    if (data instanceof Blob) {
      data = JSON.parse(await data.text());
    }

    const message = data?.message || 'Erro inesperado';

    handleErrorResponse(status, message, data, error.config);

    return Promise.reject(error);
  },
);

function handleErrorResponse(status, message, data, config) {
  const authStore = useAuthStore();

  const isAuthRoute = ['/api/v1/login', '/api/v1/ldap/login'].some((route) =>
    config.url.includes(route),
  );

  const logoutAndRedirect = () => {
    authStore.logout();
    router.push({ name: 'login' });
  };

  const errorHandlers = {
    401: () => {
      notify(message, 'negative');

      const actions = {
        true: () => {},
        false: () => logoutAndRedirect(),
      };

      actions[
        isAuthRoute ||
          message === 'Usuário ou senha inválidos' ||
          message ===
            'O domínio não é válido. Os domínios válidos são @uefs.br, @uefs.local e @discente.uefs.br.'
      ]();
    },
    403: () => {
      const errors = [
        'Usuário não ativado',
        'Usuário inativo',
        'Usuário não é servidor UEFS',
      ];
      const errorMessage = data.error || data.errors;
      return errors.includes(errorMessage) ? notify(message, 'negative') : router.go(-1);
    },
    404: () => {
      const errorMessage = data?.message.includes('No query results for model')
        ? 'Nenhum registro foi encontrado'
        : data?.message;
      notify(errorMessage, 'negative');
    },
    408: () => {
      notify('Tempo de solicitação esgotado', 'negative');
      window.location.reload();
    },
    419: () => {
      notify(
        'Sessão expirada. Por favor, atualize a página e tente novamente.',
        'negative',
      );
      router.replace('/');
    },
    422: () => {
      const errors = data?.errors || {};
      const messagesErrors = Object.values(errors);
      for (const index in messagesErrors) {
        if (index < 8) notify(messagesErrors[index].toString(), 'negative');
        break;
      }
    },
    429: () => {
      notify(message, 'negative');
      logoutAndRedirect();
    },
    500: () => {
      notify(
        'Erro interno do servidor. Por favor, contate a administração do sistema para mais informações.',
        'negative',
      );
    },
    default: () => {
      notify(
        message === 'This action is unauthorized.'
          ? 'Você não tem permissão para acessar este recurso'
          : message,
        'negative',
      );

      message === 'Unauthorized.' && router.replace('/admin/inicio');
      message === 'This action is unauthorized.' && router.replace('/admin/inicio');
    },
  };

  (errorHandlers[status] || errorHandlers.default)();
}

export default http;
