import { ref } from 'vue';
import { hasPermission } from '@utils/hasPermission';
import { ROLE_PERMISSION } from '@utils/permissions';

export default function useRoleConfigListPage() {
  const columns = ref([
    { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true },
    {
      name: 'name',
      required: true,
      label: 'Nome',
      align: 'left',
      field: 'name',
      sortable: true,
    },
    {
      name: 'description',
      label: 'Descrição',
      field: 'shortDescription',
      align: 'left',
      sortable: true,
    },
    {
      name: 'action',
      label: 'Opções',
      align: 'center',
      field: 'action',
      methods: {
        onConsult: hasPermission([ROLE_PERMISSION.VIEW]),
        onEdit: hasPermission([ROLE_PERMISSION.EDIT]),
        onDelete: hasPermission([ROLE_PERMISSION.DELETE]),
      },
    },
  ]);

  return {
    columns,
  };
}
