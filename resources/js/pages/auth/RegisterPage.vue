<script setup>
import AuthComponent from '@/components/AuthComponent.vue';
import RegisterForm from '@/components/auth/register/RegisterForm.vue';
import useUser from '@/composables/User/useUser';
const { loading, errors, onRegister } = useUser();
</script>
<template>
  <AuthComponent type-page="register">
    <RegisterForm :loading="loading" :errors="errors" @send="onRegister"></RegisterForm>
  </AuthComponent>
</template>
