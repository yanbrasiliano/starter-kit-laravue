<script setup>
import FormThematicArea from "@/components/thematicAreas/FormThematicArea.vue";
import { onMounted } from "vue";
import { useRoute } from "vue-router";
import { useQuasar } from "quasar";
import useThematicAreaStore from "@/store/useThematicAreaStore";

const route = useRoute();
const $q = useQuasar();
const thematicAreaStore = useThematicAreaStore();

onMounted(async () => {
  try {
    $q.loading.show();
    if (route.params.id) {
      await thematicAreaStore.fetchById(route.params.id);
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
        <div class="row text-h5 q-mt-sm q-mb-xs text-weight-bold">
          Edite as áreas temáticas
        </div>
      </q-card-section>
      <q-separator inset />
      <q-card-section>
        <div class="row justify-end">
          <span v-if="thematicAreaStore.getThematicArea" class="text-weight-bold">
            Criado em: {{ thematicAreaStore.getFormattedDate }}
          </span>
        </div>
        <FormThematicArea />
      </q-card-section>
    </q-card>
  </div>
</template>
