<script setup>
import FormThematicArea from "@/components/thematicAreas/FormThematicArea.vue";


</script>
<template>
  <div class="q-pa-md items-start q-gutter-md">
    <q-card>
      <q-card-section>
        <div class="row text-h5 q-mt-sm q-mb-xs text-weight-bold">
          Cadastro de Área Temática
        </div>
      </q-card-section>
      <q-separator inset />
      <q-card-section>
        <FormThematicArea />
      </q-card-section>
    </q-card>
  </div>
</template>
