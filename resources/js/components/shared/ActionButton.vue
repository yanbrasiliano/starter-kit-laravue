<script setup>
const emit = defineEmits(["clickAction"]);
defineProps({
  icon: String,
  label: String,
  color: String,
});
</script>
<template>
  <q-btn :icon="icon" :label="label" :color="color" @click="emit('clickAction')" />
</template>
