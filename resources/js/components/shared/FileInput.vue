<script setup>
import { computed, toRef } from 'vue';
import ErrorInput from '@components/shared/ErrorInput.vue';

const props = defineProps({
  data: [Number, Object],
  errors: [Array, null],
  type: {
    type: Array,
    default: () => ['application/pdf'],
  },
  isShow: Boolean,
  hasRemoveButton: {
    type: Boolean,
    default: true,
  },
});

const emit = defineEmits(['update', 'remove', 'download']);
const file = toRef(props, 'data');
const type = toRef(props, 'type');

const hasErrorsInTheFile = computed(() => {
  if (typeof file.value === 'number') {
    return false;
  }

  if (!file.value) {
    return true;
  }

  const isTypeInvalid = !type.value.includes(file.value?.type);
  const isSizeInvalid = file.value?.size > 1024 * 1024 * 16;

  return isTypeInvalid || isSizeInvalid;
});
</script>

<template>
  <q-file
    v-if="(!file || hasErrorsInTheFile) && !props.isShow"
    :model-value="file"
    filled
    bottom-slots
    label="Selecione o arquivo"
    :error="errors?.length > 0"
    :rules="[
      (val) =>
        !val || (val && type.includes(val?.type)) || 'O tipo do arquivo não é válido.',
      (val) =>
        !val ||
        (val && val?.size <= 1024 * 1024 * 16) ||
        'O arquivo excede o limite de tamanho.',
    ]"
    @update:model-value="emit('update', $event)">
    <template #prepend>
      <q-icon name="cloud_upload" @click.stop.prevent />
    </template>
    <template #append>
      <q-icon
        name="close"
        class="cursor-pointer"
        @click.stop.prevent="emit('remove', null)" />
    </template>
    <template #error>
      <ErrorInput :errors="errors"></ErrorInput>
    </template>
  </q-file>
  <div v-else>
    <div class="row items-center">
      <span>
        {{ file?.name }}
      </span>
      <q-btn
        v-if="file"
        flat
        color="primary"
        icon="download"
        title="Download"
        @click="emit('download', file?.id ?? file)" />
      <q-btn
        v-if="hasRemoveButton && !props.isShow"
        flat
        color="primary"
        icon="delete"
        title="Remover"
        @click="emit('remove', null)" />
    </div>
    <div class="row q-mb-lg items-center">
      <ErrorInput :errors="errors"></ErrorInput>
    </div>
  </div>
</template>
