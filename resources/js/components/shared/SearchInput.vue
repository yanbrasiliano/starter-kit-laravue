<script setup>
import { ref } from 'vue';

const emit = defineEmits(['triggerSearch', 'updateSearch']);
const searchValue = ref('');
</script>
<template>
  <q-input
    v-model="searchValue"
    filled
    class="search-input"
    label="Pesquise por..."
    @update:model-value="emit('updateSearch', searchValue)">
    <template #prepend>
      <q-icon
        name="search"
        class="cursor-pointer"
        @click="emit('triggerSearch', searchValue)" />
    </template>
  </q-input>
</template>