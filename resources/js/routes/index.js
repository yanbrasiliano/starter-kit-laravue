import useAuthStore from '@/store/useAuthStore';
import { hasPermission } from '@utils/hasPermission';
import axios from 'axios';
import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes';

const router = createRouter({
  history: createWebHistory(),
  routes,
});

const fetchCsrfCookie = async () => {
  await axios.get('/sanctum/csrf-cookie');
};

const handleRouteProtection = (to, from, next) => {
  const authStore = useAuthStore();
  const requiresAuth = to.matched.some((record) => record.meta.requiresAuth);
  const isUserLoggedIn = authStore.isUserLoggedIn;

  const hasPermissionUser = to.matched.some((record) => {
    const roles = record.meta?.roles;
    return (
      (record.meta.requiresAuth &&
        roles &&
        Array.isArray(roles) &&
        hasPermission(roles)) ||
      (record.meta.requiresAuth && !roles)
    );
  });

  if (requiresAuth && !isUserLoggedIn && !hasPermissionUser) {
    return next({ name: 'login' }); // Usuário não logado e sem permissão
  }

  if (!requiresAuth && isUserLoggedIn) {
    return next({ name: 'notFound' }); // Usuário logado, mas não precisa de autenticação
  }

  if (requiresAuth && isUserLoggedIn && !hasPermissionUser) {
    return next({ name: 'accessDenied' }); // Usuário logado, mas não tem permissão
  }

  return next();
};

router.beforeEach(async (to, from, next) => {
  await fetchCsrfCookie();
  handleRouteProtection(to, from, next);
});

export default router;
