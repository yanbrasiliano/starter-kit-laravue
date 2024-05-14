import { THEMATIC_AREA_PERMISSION } from '@utils/permissions';

const thematicAreaRoutes = {
  children: [
    {
      path: '',
      name: 'listThematicAreas',
      component: async () => import('@pages/admin/thematicAreas/ListPage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Áreas Temáticas',
        icon: 'inventory',
        roles: [THEMATIC_AREA_PERMISSION.LIST],
      },
    },
    {
      path: 'criar',
      name: 'createThematicAreas',
      component: async () => import('@pages/admin/thematicAreas/CreatePage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Áreas Temáticas',
        icon: 'inventory',
        roles: [THEMATIC_AREA_PERMISSION.CREATE],
      },
    },
    {
      path: 'editar/:id',
      name: 'editThematicAreas',
      component: async () => import('@pages/admin/thematicAreas/EditPage.vue'),
      meta: {
        requiresAuth: true,
        module: 'Áreas Temáticas',
        icon: 'inventory',
        roles: [THEMATIC_AREA_PERMISSION.EDIT],
      },
    },
  ],
};

export default thematicAreaRoutes;
