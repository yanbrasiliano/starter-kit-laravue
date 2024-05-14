import { ROLE_PERMISSION } from '@utils/permissions';

const roleRoutes = {
  children: [
    {
      path: '',
      name: 'listRoles',
      component: async () => import('@pages/admin/roles/ListPage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Profiles',
        icon: 'contacts',
        roles: [ROLE_PERMISSION.LIST],
      },
    },
    {
      path: 'show/:id',
      name: 'showRole',
      component: async () => import('@pages/admin/roles/ShowPage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Profiles',
        icon: 'contacts',
        roles: [ROLE_PERMISSION.VIEW],
      },
    },
    {
      path: 'edit/:id',
      name: 'editRoles',
      component: async () => import('@pages/admin/roles/EditPage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Profiles',
        icon: 'contacts',
        roles: [ROLE_PERMISSION.EDIT],
      },
    },
    {
      path: 'create',
      name: 'createRoles',
      component: async () => import('@pages/admin/roles/CreatePage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Profiles',
        icon: 'contacts',
        roles: [ROLE_PERMISSION.CREATE],
      },
    },
  ],
};

export default roleRoutes;
