import http from './AxiosClient';

async function resetPassword(credentials) {
  return await http.post('/api/v1/reset-password', credentials);
}

async function requestPasswordRecovery(data) {
  return await http.post('/api/v1/forgot-password', data);
}

export default { resetPassword, requestPasswordRecovery };
