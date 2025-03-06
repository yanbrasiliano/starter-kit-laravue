<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

defineProps({
  title: String,
  message: String,
  errorImage: String,
});
</script>
<template>
  <div class="page text-center">
    <q-card>
      <q-card-section class="card__content">
        <h2 class="card__heading">{{ title }}</h2>
        <p class="card__message">{{ message }}</p>
        <q-btn class="q-mt-sm" flat color="primary" @click="router.go(-1)">
          Voltar
        </q-btn>
      </q-card-section>
      <q-img class="card__image q-mt-md" :src="errorImage" fit="contain" />
    </q-card>
  </div>
</template>

<style lang="css">
@import '@css/errors/errors-style.css';
</style>
