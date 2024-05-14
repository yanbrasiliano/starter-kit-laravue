<script setup>
import { onMounted } from 'vue';
import { useRoute } from 'vue-router';
import Form from '@/components/units/FormUnit.vue';
import useUnit from '@/composables/Unit/useUnit';
const { sendUnit, loading, get, unit, errors } = useUnit();

const route = useRoute();

onMounted(async () => {
  await get(route.params.id);
});
</script>
<template>
  <div class="q-pa-md items-start q-gutter-md">
    <q-card class="q-pa-md">
      <q-card-section>
        <div class="row text-h5 q-mt-sm q-mb-xs text-weight-bold">
          Edite as suas unidades
        </div>
      </q-card-section>
      <q-separator inset />
      <q-card-section>
        <Form
          v-if="unit"
          :loading="loading"
          :unit="unit"
          :errors="errors"
          @send="sendUnit" />
      </q-card-section>
    </q-card>
  </div>
</template>
