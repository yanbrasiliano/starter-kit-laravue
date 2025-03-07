<script setup>
import ErrorComponent from '@/components/errors/ErrorComponent.vue';
import error403Image from '@/assets/error-403-image.png';

const title = 'Oops...Acesso Negado!';
const message = 'Você não tem permissão para acessar este conteúdo';
</script>
<template>
  <ErrorComponent :title="title" :message="message" :error-image="error403Image" />
</template>
