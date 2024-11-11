import http from './AxiosClient';

async function ldapAuthenticate(credentials) {
  return await http.post('/api/v1/ldap/login', credentials);
}

async function getCivilServantByCpf(cpf) {
  return await http.get('/api/v1/ldap/civil-servant', { params: { cpf } });
}

async function getStudentByCpfAndEnrollment(cpf, enrollment) {
  return await http.get('/api/v1/ldap/student', { params: { cpf, enrollment } });
}

async function getCivilServantByCpfPlain(cpf, isUpdate = false) {
  return await http.get('/api/v1/ldap/civil-servant/plain', {
    params: { cpf, isUpdate },
  });
}

async function getStudentByCpfAndEnrollmentPlain(cpf, enrollment, isUpdate = false) {
  return await http.get('/api/v1/ldap/student/plain', {
    params: { cpf, enrollment, isUpdate },
  });
}

async function ldapRegister(data) {
  return await http.post('/api/v1/ldap/register', data);
}

export {
  ldapAuthenticate,
  getCivilServantByCpf,
  getStudentByCpfAndEnrollment,
  getCivilServantByCpfPlain,
  getStudentByCpfAndEnrollmentPlain,
  ldapRegister,
};
