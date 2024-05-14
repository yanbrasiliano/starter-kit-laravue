import MainLayout from '@layouts/MainLayout.vue';
import AdminLayout from '@layouts/AdminLayout.vue';
import userRoutes from '@/routes/userRoutes';
import roleRoutes from '@/routes/roleRoutes';
import unitRoutes from '@/routes/unitRoutes';
import adminHomeRoutes from '@/routes/adminRoutes';
import publicRoutes from '@/routes/publicRoutes/publicRoutes';
import thematicAreaRoutes from '@/routes/thematicAreasRoutes';
import NotFoundPage from '@/pages/erros/NotFoundPage.vue';
import AccessDeniedPage from '../pages/erros/AccessDeniedPage.vue';

const routes = [
  {
    path: '/',
    component: MainLayout,
    children: publicRoutes,
  },
  {
    path: '/admin',
    component: AdminLayout,
    children: [
      adminHomeRoutes,
      {
        path: 'usuarios',
        children: userRoutes.children,
      },
      {
        path: 'areas-tematicas',
        children: thematicAreaRoutes.children,
      },
      {
        path: 'perfis',
        children: roleRoutes.children,
      },
      {
        path: 'unidades',
        children: unitRoutes.children,
      },
      {
        path: 'notFound',
        children: [
          {
            path: 'error404',
            name: 'naoEncontrado',
            component: NotFoundPage,
            meta: {
              requiresAuth: true,
              module: 'Error',
            },
          },
        ],
      },
      {
        path: 'accessDenied',
        children: [
          {
            path: 'error403',
            name: 'accessDenied',
            component: AccessDeniedPage,
            meta: {
              requiresAuth: true,
              module: 'Error',
            },
          },
        ],
      },
    ],
  },
  { path: '/:pathMatch(.*)*', name: 'notFound', component: NotFoundPage },
];

export default routes;
