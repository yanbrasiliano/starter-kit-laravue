<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  modelValue: Boolean,
  item: Object,
});

const emit = defineEmits(['update:modelValue', 'confirm', 'cancel']);

const show = ref(props.modelValue);
const itemDelete = ref(props.item);
const deletionReason = ref('');

watch(
  () => props.modelValue,
  (newValue) => {
    show.value = newValue;
  },
  { immediate: true },
);

watch(
  () => props.item,
  (newItem) => {
    itemDelete.value = newItem;
  },
  { immediate: true },
);

const confirmDeletion = () => {
  if (deletionReason.value && itemDelete.value) {
    emit('confirm', { row: itemDelete.value, reason: deletionReason.value });
    show.value = false;
    deletionReason.value = '';
  }
};

const cancelDeletion = () => {
  emit('cancel');
  show.value = false;
  deletionReason.value = '';
};
</script>

<template>
  <q-dialog v-model="show" persistent>
    <q-card>
      <q-card-section class="row items-center justify-between">
        <div class="text-h6">Exclusão de Usuário</div>
        <q-btn icon="close" flat round @click="cancelDeletion" />
      </q-card-section>
      <q-card-section>
        <q-input
          v-model="deletionReason"
          filled
          type="textarea"
          autogrow
          maxlength="100"
          hint="Máximo de 100 caracteres."
          label="Insira o motivo da exclusão*"
          style="min-height: 100px" />
      </q-card-section>
      <q-card-actions align="right">
        <q-btn flat label="Cancelar" color="primary" @click="cancelDeletion" />
        <q-btn
          flat
          label="Confirmar Exclusão"
          color="red"
          :disabled="!deletionReason"
          @click="confirmDeletion" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>
