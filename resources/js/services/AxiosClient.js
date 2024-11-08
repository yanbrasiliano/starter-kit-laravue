import axios from 'axios';
import { Loading, Notify } from 'quasar';
import useAuthStore from '@/store/useAuthStore';
import router from '@/routes';

const IS_DEBUG = import.meta.env.VITE_APP_DEBUG === 'true';

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

const http = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  timeout: 30000,
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'Content-Type': 'application/json',
  },
});

http.interceptors.response.use(
  (response) => response,
  (error) => {
    Loading.hide();
    console.log(error);
    if (!error.response) {
      Notify.create({
        position: 'top-right',
        color: 'negative',
        message: 'Ocorreu um erro de rede inesperado.',
      });
      return Promise.reject(error);
    }

    const timeoutMessage =
      'Não foi possível carregar esta página corretamente, verifique sua conexão com a internet e tente novamente';
    if (error.code === 'ECONNABORTED') {
      notifyError(timeoutMessage);
      return Promise.reject({ message: timeoutMessage });
    }

    const { status, data } = error.response;
    const message = data?.message || 'Erro inesperado';

    handleErrorResponse(status, message, data);

    if (IS_DEBUG) {
      return Promise.reject(error);
    }
    return Promise.reject(error.response.data);
  },
);

function notifyError(message) {
  Notify.create({
    position: 'top-right',
    color: 'negative',
    message: message,
  });
}

function handleErrorResponse(status, message, data) {
  const notifyError = (msg) => {
    Notify.create({
      position: 'top-right',
      color: 'negative',
      message: msg,
    });
  };
  const commonErrorAction = (msg) => {
    notifyError(msg);
    const authStore = useAuthStore();
    status === 401 && msg === 'Usuário ou senha inválidos'
      ? authStore.logout()
      : status === 401 && (authStore.logout(), router.push({ name: 'login' }));
  };

  const errors = data?.errors || {};

  switch (status) {
    case 403: {
      data.error === 'Usuário não ativado' ? notifyError(message) : router.go(-1);
      break;
    }
    case 404:
    case 401:
    case 429: {
      commonErrorAction(message);
      break;
    }
    case 408: {
      notifyError('Request Timeout');
      window.location.reload();
      break;
    }
    case 422: {
      const messagesErrors = Object.values(errors);
      for (const values of messagesErrors) {
        notifyError(values.toString());
      }
      break;
    }
    case 419: {
      notifyError('Session expired or invalid token.');
      router.replace('/');
      break;
    }
    case 500: {
      notifyError(
        data.message ||
          'Erro interno do servidor. Tente novamente mais tarde ou entre em contato com a equipe de desenvolvimento.',
      );
      break;
    }
    default: {
      notifyError(
        message === 'This action is unauthorized.'
          ? 'You do not have permission to access this resource or your session has expired.'
          : message,
      );

      if (message === 'Unauthorized.') {
        message =
          'You do not have permission to access this resource or your session has expired.';
        router.replace('/admin/home');
      }

      if (message === 'This action is unauthorized.') {
        router.replace('/admin/home');
      }
      break;
    }
  }
}

export default http;
