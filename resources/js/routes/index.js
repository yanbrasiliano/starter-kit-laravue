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
  // User not logged in and no permission
  if (requiresAuth && !isUserLoggedIn && !hasPermissionUser) {
    return next({ name: 'login' }); 
  }
  // Prevent logged-in users from accessing login page. change home to intended location.
  if (!requiresAuth && isUserLoggedIn && to.name === 'login') {
    return next({ name: 'accessDenied' }); 
  }
  // User logged in but no permission
  if (requiresAuth && isUserLoggedIn && !hasPermissionUser) {
    return next({ name: 'accessDenied' }); 
  }
  // Allow navigation if all conditions are met
  return next(); 
};

router.beforeEach(async (to, from, next) => {
  await fetchCsrfCookie();
  handleRouteProtection(to, from, next);
});

export default router;
