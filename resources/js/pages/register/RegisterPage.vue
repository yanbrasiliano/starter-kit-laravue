<script setup>
import RegisterComponent from '@/components/register/RegisterComponent.vue';
import RegisterForm from '@/components/register/RegisterForm.vue';
import useUser from '@/composables/User/useUser';
const { loading, errors, onRegister } = useUser();
</script>

<template>
  <RegisterComponent>
    <RegisterForm :loading="loading" :errors="errors" @send="onRegister"></RegisterForm>
  </RegisterComponent>
</template>
