<script setup>
import AuthComponent from '@/components/AuthComponent.vue';
import ResetPasswordForm from '@/components/auth/password/ResetPasswordForm.vue';
</script>

<template>
  <AuthComponent type-page="resetPassword">
    <ResetPasswordForm></ResetPasswordForm>
  </AuthComponent>
</template>
