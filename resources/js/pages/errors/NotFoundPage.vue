<script setup>
import ErrorComponent from '@/components/errors/ErrorComponent.vue';
import error404Image from '@/assets/error-404-image.png';

const title = 'Oops...Página não encontrada!';
const message =
  'Parece que você tentou acessar uma página que não existe. Clique no botão abaixo para voltar para a página anterior.';
</script>
<template>
  <ErrorComponent :title="title" :message="message" :error-image="error404Image" />
</template>
