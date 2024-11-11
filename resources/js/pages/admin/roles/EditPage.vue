<script setup>
import FormRole from '@/components/roles/FormRole.vue';
import { onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useQuasar } from 'quasar';
import useRoleStore from '@/store/useRoleStore';

const route = useRoute();
const $q = useQuasar();
const roleStore = useRoleStore();

onMounted(async () => {
  try {
    $q.loading.show();
    if (route.params.id) {
      await roleStore.fetchById(route.params.id);
    }
  } finally {
    $q.loading.hide();
  }
});
</script>

<template>
  <div class="q-pa-md items-start q-gutter-md">
    <q-card>
      <q-card-section>
        <div class="row text-h5 q-mt-sm q-mb-xs text-weight-bold">Edit Roles</div>
      </q-card-section>
      <q-separator inset />
      <q-card-section>
        <div class="row justify-end">
          <span v-if="roleStore.getRole" class="text-weight-bold">
            Created on: {{ roleStore.getFormattedDate }}
          </span>
        </div>
        <FormRole />
      </q-card-section>
    </q-card>
  </div>
</template>
