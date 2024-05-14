<script setup>
import { onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
const props = defineProps({
  profiles: Array,
  loading: Boolean,
  user: Object,
});

const emit = defineEmits(['send']);
const route = useRoute();

const formData = ref({
  send_random_password: false,
  active: 0,
});

onMounted(() => {
  formData.value.name = props.user?.name || '';
  formData.value.cpf = props.user?.cpf || '';
  formData.value.email = props.user?.email || '';
  formData.value.role = props.user?.roles?.[props.user.roles.length - 1] || null;
  formData.value.active = props.user?.active ? 1 : 0;
});

const onSubmit = async () => {
  emit('send', {
    email: formData.value.email,
    name: formData.value.name,
    cpf: formData.value.cpf,
    password: formData.value.password,
    role_id: formData.value.role.id,
    active: formData.value.active ?? 0,
    send_random_password: formData.value.send_random_password,
  });
};

watch([formData, () => formData.value.send_random_password], () => {
  if (formData.value.send_random_password) formData.value.password = null;
});
</script>

<template>
  <q-form class="q-gutter-md" @submit.prevent="onSubmit">
    <div>
      <label for="name" class="text-weight-bold">Name</label>
      <q-input
        v-model="formData.name"
        filled
        placeholder="Enter the name"
        lazy-rules
        autofocus
        :rules="[(val) => (val && val.length > 0) || 'Please enter the name']" />
    </div>
    <div>
      <label for="email" class="text-weight-bold">Email</label>
      <q-input
        v-model="formData.email"
        filled
        type="email"
        placeholder="Enter your email"
        lazy-rules
        autofocus
        :rules="[(val) => (val && val.length > 0) || 'Please enter your email']" />
    </div>
    <div>
      <label for="password" class="text-weight-bold">Password</label>
      <q-input
        v-model="formData.password"
        filled
        label="Password"
        type="password"
        placeholder="Enter your password"
        lazy-rules
        autofocus
        :rules="[]"
        :readonly="formData.send_random_password" />
    </div>
    <div v-if="route.name !== 'editUsers'">
      <q-checkbox
        v-model="formData.send_random_password"
        label="Send random password by email" />
    </div>
    <div class="row">
      <div class="col-md-6">
        <label for="role_id" class="text-weight-bold">Role</label>
        <q-select
          v-model="formData.role"
          :style="{ width: '100%', minWidth: '200px' }"
          :options="props.profiles"
          option-label="name"
          option-value="id"
          filled
          label="Select a role"
          autofocus
          :rules="[
            (val) => (val && (val.id || val.id === undefined)) || 'Please select a role',
          ]">
          <template #no-option>
            <q-item>
              <q-item-section class="text-italic text-grey">
                No options available
              </q-item-section>
            </q-item>
          </template>
        </q-select>
      </div>
      <div>
        <q-toggle
          v-model="formData.active"
          :style="{ display: 'flex', flexDirection: 'column-reverse' }"
          :true-value="1"
          :false-value="0"
          class="text-weight-bold"
          name="active"
          label="Active"
          autofocus
          :rules="[(val) => val !== undefined || 'Please select the user status']" />
      </div>
    </div>
    <div class="q-mt-lg q-gutter-sm">
      <q-btn
        :loading="props.loading"
        class="text-weight-bold"
        label="Save"
        type="submit"
        color="secondary" />
      <q-btn
        flat
        class="text-weight-bold"
        label="Return"
        type="button"
        color="primary"
        :to="{ name: 'listUsers' }" />
    </div>
  </q-form>
</template>
