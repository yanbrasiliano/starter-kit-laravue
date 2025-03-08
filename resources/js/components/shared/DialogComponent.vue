<script setup>
import { useDialogPluginComponent } from 'quasar';

defineProps({
  title: String,
  text: String,
});

defineEmits([...useDialogPluginComponent.emits]);

const { dialogRef, onDialogHide, onDialogOK } = useDialogPluginComponent();
</script>
<template>
  <q-dialog ref="dialogRef" persistent @hide="onDialogHide">
    <q-card style="min-width: 350px" class="q-py-md">
      <q-card-section class="row justify-center">
        <div class="col-10 text-center">
          <p class="text-weight-bold fs-18 q-mb-none">{{ title }}</p>
          <p class="text-weight-bold fs-18 q-mb-none">{{ text }}</p>
        </div>
      </q-card-section>

      <q-card-actions align="center">
        <q-btn
          v-close-popup
          outline
          label="Sim"
          color="secondary"
          @click="onDialogOK()" />
        <q-btn v-close-popup label="Não" color="secondary" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>
