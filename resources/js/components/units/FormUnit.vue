<script setup>
import { onMounted, ref } from 'vue';
import ErrorInput from '@components/shared/ErrorInput.vue';

const props = defineProps({
  profiles: Array,
  loading: Boolean,
  unit: Object,
  errors: null,
});

const emit = defineEmits(['send']);

const formData = ref({
  id: null,
  description: null,
  acronym: null,
});

onMounted(() => {
  formData.value.id = props.unit?.id;
  formData.value.description = props.unit?.description;
  formData.value.acronym = props.unit?.acronym;
});

const onSubmit = async () => {
  emit('send', formData.value);
};
</script>

<template>
  <q-form class="q-gutter-md" @submit="onSubmit">
    <div>
      <label for="description" class="text-weight-bold">Descrição</label>
      <q-input
        v-model="formData.description"
        filled
        placeholder="Digite a descrição da unidade"
        lazy-rules
        bottom-slots
        :error="errors && errors?.description?.length > 0">
        <template #error>
          <ErrorInput :errors="errors.description"></ErrorInput>
        </template>
      </q-input>
    </div>
    <div>
      <label for="email" class="text-weight-bold">Sigla</label>
      <q-input
        v-model="formData.acronym"
        filled
        placeholder="Digite a sigla da unidade"
        lazy-rules
        bottom-slots
        :error="errors && errors?.acronym?.length > 0">
        <template #error>
          <ErrorInput :errors="errors.acronym"></ErrorInput>
        </template>
      </q-input>
    </div>

    <div class="q-mt-lg q-gutter-sm">
      <q-btn
        :loading="props.loading"
        class="text-weight-bold"
        label="Salvar"
        type="submit"
        color="secondary" />
      <q-btn
        flat
        class="text-weight-bold"
        label="Voltar"
        type="submit"
        color="primary"
        :loading="loading"
        :to="{ name: 'listUnits' }" />
    </div>
  </q-form>
</template>
