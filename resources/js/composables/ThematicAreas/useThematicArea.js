import { ref } from 'vue';
import { hasPermission } from '@utils/hasPermission';
import { THEMATIC_AREA_PERMISSION } from '@utils/permissions';

export default function useThematicArea() {
  const columns = ref([
    { name: 'id', align: 'left', label: 'ID', field: 'id', sortable: true },
    {
      name: 'description',
      label: 'Descrição',
      field: 'description',
      align: 'left',
      sortable: true,
    },
    {
      name: 'action',
      label: 'Opções',
      align: 'center',
      field: (row) => row.id,
      format: (val) => `${val}`,
      methods: {
        onConsult: false,
        onEdit: hasPermission([THEMATIC_AREA_PERMISSION.EDIT]),
        onDelete: hasPermission([THEMATIC_AREA_PERMISSION.DELETE]),
      },
    },
  ]);
  return {
    columns,
  };
}
