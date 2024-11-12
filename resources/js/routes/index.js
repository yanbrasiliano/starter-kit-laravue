import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes';
import axios from 'axios';
import useAuthStore from '@/store/useAuthStore';
import { hasPermission } from '@utils/hasPermission';

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
  const hasPermissionUser = to.matched.some(
    (record) =>
      (record.meta.requiresAuth &&
        record.meta.roles &&
        hasPermission(record.meta.roles)) ||
      (record.meta.requiresAuth && !record?.meta?.roles),
  );

  const routeActions = {
    true_false_false: () => next({ name: 'login' }),
    false_true: () => next({ name: 'notFound' }),
    true_true_false: () => next({ name: 'accessDenied' }),
    default: () => next(),
  };

  const actionKey = `${requiresAuth}_${isUserLoggedIn}_${hasPermissionUser}`;
  const action = routeActions[actionKey] || routeActions['default'];
  action();
};

router.beforeEach(async (to, from, next) => {
  await fetchCsrfCookie();
  handleRouteProtection(to, from, next);
});

export default router;
