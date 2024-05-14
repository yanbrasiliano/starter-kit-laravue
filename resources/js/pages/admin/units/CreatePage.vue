<script setup>
import Form from '@/components/units/FormUnit.vue';
import useUnit from '@/composables/Unit/useUnit';
const { sendUnit, loading, errors } = useUnit();
</script>
<template>
  <div class="q-pa-md items-start q-gutter-md">
    <q-card class="q-pa-md">
      <q-card-section>
        <div class="row text-h5 q-mt-sm q-mb-xs text-weight-bold">
          Cadastro de Unidades
        </div>
      </q-card-section>
      <q-separator inset />
      <q-card-section>
        <Form :loading="loading" :errors="errors" @send="sendUnit" />
      </q-card-section>
    </q-card>
  </div>
</template>
