<script setup>
import FormRole from '@/components/roles/FormRole.vue';
</script>
<template>
  <div class="q-pa-md items-start q-gutter-md">
    <q-card>
      <q-card-section>
        <div class="row text-h5 q-mt-sm q-mb-xs text-weight-bold">
          Cadastre os seus Perfis
        </div>
      </q-card-section>
      <q-separator inset />
      <q-card-section>
        <FormRole :block-select-permission="false" />
      </q-card-section>
    </q-card>
  </div>
</template>
