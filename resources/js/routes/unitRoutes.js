import { UNIT_PERMISSION } from '@utils/permissions';

const unitRoutes = {
  children: [
    {
      path: '',
      name: 'listUnits',
      component: async () => import('@pages/admin/units/ListPage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Unidades',
        icon: 'account_balance',
        roles: [UNIT_PERMISSION.LIST],
      },
    },
    {
      path: 'editar/:id',
      name: 'editUnits',
      component: async () => import('@pages/admin/units/EditPage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Unidades',
        icon: 'account_balance',
        roles: [UNIT_PERMISSION.EDIT],
      },
    },
    {
      path: 'criar',
      name: 'createUnits',
      component: async () => import('@pages/admin/units/CreatePage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Unidades',
        icon: 'account_balance',
        roles: [UNIT_PERMISSION.CREATE],
      },
    },
  ],
};

export default unitRoutes;
