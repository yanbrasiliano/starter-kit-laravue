import { ref } from 'vue';
import { format } from 'date-fns';
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
      field: (row) => row.name,
      format: (val) => `${val}`,
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
      name: 'created_at',
      label: 'Criado em',
      align: 'left',
      field: 'createdAt',
      format: (val) => format(new Date(val), 'dd/MM/yyyy'),
      sortable: true,
    },
    {
      name: 'action',
      label: 'Opções',
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
