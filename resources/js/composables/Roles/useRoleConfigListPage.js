import { ref } from 'vue';
import { hasPermission } from '@utils/hasPermission';
import { ROLE_PERMISSION } from '@utils/permissions';

export default function useRoleConfigListPage() {
  const columns = ref([
    { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true },
    {
      name: 'name',
      required: true,
      label: 'Name',
      align: 'left',
      field: (row) => row.name,
      format: (val) => `${val}`,
      sortable: true,
    },
    {
      name: 'description',
      label: 'Description',
      field: 'shortDescription',
      align: 'left',
      sortable: true,
    },

    {
      name: 'action',
      label: 'Options',
      align: 'center',
      field: (row) => row.id,
      format: (val) => `${val}`,
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
