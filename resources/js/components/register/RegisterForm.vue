<script setup>
import { ref } from 'vue';
import ErrorInput from '@components/shared/ErrorInput.vue';

const props = defineProps({
  loading: Boolean,
  errors: null,
});
const show = ref({ isPassword: true, isPasswordConfirmation: true });
const formData = ref({
  role: { name: 'Reviewer', value: 'reviewer' },
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});
const emit = defineEmits(['send']);

const onSubmit = async () => {
  emit('send', formData.value);
};
</script>

<template>
  <q-form @submit.prevent="onSubmit">
    <div>
      <label for="role" class="text-weight-bold">User Type</label>
      <q-select
        v-model="formData.role"
        :style="{ width: '100%', minWidth: '200px' }"
        :options="[{ name: 'Reviewer', value: 'reviewer' }]"
        option-label="name"
        option-value="value"
        filled
        placeholder="Select your user type"
        lazy-rules
        bottom-slots
        :error="props.errors && props.errors?.role?.length > 0">
        <template #error>
          <ErrorInput :errors="props.errors.role"></ErrorInput>
        </template>
      </q-select>
    </div>
    <div>
      <label for="name" class="text-weight-bold">Full Name</label>
      <q-input
        v-model="formData.name"
        filled
        placeholder="Enter your name"
        lazy-rules
        bottom-slots
        :error="props.errors && props.errors?.name?.length > 0">
        <template #error>
          <ErrorInput :errors="props.errors.name"></ErrorInput>
        </template>
      </q-input>
    </div>

    <div>
      <label for="cpf" class="text-weight-bold">CPF</label>
      <q-input
        v-model="formData.cpf"
        filled
        placeholder="Enter your CPF"
        lazy-rules
        bottom-slots
        mask="###.###.###-##"
        unmasked-value
        :error="props.errors && props.errors?.cpf?.length > 0">
        <template #error>
          <ErrorInput :errors="props.errors.cpf"></ErrorInput>
        </template>
      </q-input>
    </div>

    <div>
      <label for="email" class="text-weight-bold">Email</label>
      <q-input
        v-model="formData.email"
        filled
        placeholder="Enter your email"
        lazy-rules
        bottom-slots
        :error="props.errors && props.errors?.email?.length > 0">
        <template #error>
          <ErrorInput :errors="props.errors.email"></ErrorInput>
        </template>
      </q-input>
    </div>

    <div>
      <label for="password" class="text-weight-bold">Password</label>
      <q-input
        v-model="formData.password"
        :type="show.isPassword ? 'password' : 'text'"
        filled
        placeholder="Enter your password"
        lazy-rules
        bottom-slots
        :error="props.errors && props.errors?.password?.length > 0">
        <template #error>
          <ErrorInput :errors="props.errors.password"></ErrorInput>
        </template>
        <template #append>
          <q-icon
            :name="show.isPassword ? 'visibility_off' : 'visibility'"
            class="cursor-pointer"
            @click="show.isPassword = !show.isPassword" />
        </template>
      </q-input>
    </div>

    <div>
      <label for="password_confirmation" class="text-weight-bold">Confirm Password</label>
      <q-input
        v-model="formData.password_confirmation"
        :type="show.isPasswordConfirmation ? 'password' : 'text'"
        filled
        placeholder="Confirm your password"
        lazy-rules
        bottom-slots
        :error="props.errors && props.errors?.password_confirmation?.length > 0">
        <template #error>
          <ErrorInput :errors="props.errors.password_confirmation"></ErrorInput>
        </template>
        <template #append>
          <q-icon
            :name="show.isPasswordConfirmation ? 'visibility_off' : 'visibility'"
            class="cursor-pointer"
            @click="show.isPasswordConfirmation = !show.isPasswordConfirmation" />
        </template>
      </q-input>
    </div>

    <div>
      <q-btn
        :loading="props.loading"
        label="Register"
        type="submit"
        color="secondary"
        class="full-width" />
    </div>
    <div class="q-mt-md">
      <span :style="{ color: '#718096', marginRight: '5px', fontSize: '12px' }">
        By registering, I agree to the Terms and Policies of the System.
      </span>
    </div>
  </q-form>
</template>

<style scoped>
.q-card {
  max-width: none;
  width: 100%;
}
.q-btn {
  width: 100%;
  margin-top: 20px;
}
</style>
