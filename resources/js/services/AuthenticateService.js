import http from './AxiosClient';

async function authenticate(credentials) {
  return await http.post('/api/v1/login', credentials);
}

async function unauthenticate() {
  return await http.post('/api/v1/logout');
}

async function myProfile() {
  return await http.get('/api/v1/auth/my-profile');
}

export { authenticate, unauthenticate, myProfile };
