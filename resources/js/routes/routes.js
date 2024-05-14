import MainLayout from '@layouts/MainLayout.vue';
import AdminLayout from '@layouts/AdminLayout.vue';
import userRoutes from '@/routes/userRoutes';
import roleRoutes from '@/routes/roleRoutes';
import adminHomeRoutes from '@/routes/adminRoutes';
import publicRoutes from '@/routes/publicRoutes/publicRoutes';
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
        path: 'users',
        children: userRoutes.children,
      },
      {
        path: 'profiles',
        children: roleRoutes.children,
      },
      {
        path: 'notFound',
        children: [
          {
            path: 'error404',
            name: 'notFound',
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
