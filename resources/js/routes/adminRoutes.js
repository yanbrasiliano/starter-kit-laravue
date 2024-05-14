const adminHomeRoutes = {
  path: 'inicio',
  name: 'adminHome',
  component: async () => import('@pages/admin/AdminHomePage.vue'),
  meta: {
    requiresAuth: true,
    module: 'Painel Inicial',
    icon: 'space_dashboard',
  },
};

export default adminHomeRoutes;
