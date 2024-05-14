<script setup>
import error403Image from '@/assets/error-403-image.png';
import { useRouter } from 'vue-router';

const router = useRouter();
</script>

<template>
  <div class="error-page">
    <q-card class="error-card">
      <q-card-section class="error-card-content">
        <h2 class="error-heading">Oops...Acesso Negado!</h2>
        <p class="error-message">Você não tem permissão para acessar este conteúdo</p>
        <q-btn style="margin-top: 15px" flat color="primary" @click="router.go(-1)">
          Return
        </q-btn>
      </q-card-section>
      <q-img
        style="width: 100%; margin: 0%; height: auto; margin-bottom: 30px"
        class="q-mt-xl"
        :src="error403Image"
        fit="contain" />
    </q-card>
  </div>
</template>

<style scoped>
.error-page {
  display: flex;
  justify-content: center;
  align-items: center;
}

.error-card {
  width: 100%;
  max-width: 145vh;
  height: 100%;
  max-height: 100vh;
  text-align: center;
}

.error-heading {
  font-size: 3.2rem;
  font-weight: 400;
  margin-bottom: 15px;
  color: #3b3b3b;
}

.error-message {
  font-size: 1.35rem;
  margin-bottom: 0px;
  color: #3b3b3b;
}

.error-link {
  text-decoration: none;
}
</style>
