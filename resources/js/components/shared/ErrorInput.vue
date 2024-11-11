<script setup>
const props = defineProps({
  errors: {
    type: Array,
    default: () => {
      [];
    },
  },
});
</script>
<template>
  <div v-if="props.errors">
    <p v-for="(error, i) in props.errors" :key="i" class="text-negative">
      {{ error }}
    </p>
  </div>
</template>
