import { USER_PERMISSION } from '@utils/permissions';

const userRoutes = {
  children: [
    {
      path: '',
      name: 'listUsers',
      component: async () => import('@pages/admin/users/ListPage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Users',
        icon: 'people_alt',
        roles: [USER_PERMISSION.LIST],
      },
    },
    {
      path: 'visualizar/:id',
      name: 'showUsers',
      component: async () => import('@pages/admin/users/ShowPage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Users',
        icon: 'people_alt',
        roles: [USER_PERMISSION.VIEW],
      },
    },
    {
      path: 'editar/:id',
      name: 'editUsers',
      component: async () => import('@pages/admin/users/EditPage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Users',
        icon: 'people_alt',
        roles: [USER_PERMISSION.EDIT],
      },
    },
    {
      path: 'criar',
      name: 'createUsers',
      component: async () => import('@pages/admin/users/CreatePage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Users',
        icon: 'people_alt',
        roles: [USER_PERMISSION.CREATE],
      },
    },
  ],
};

export default userRoutes;
