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
  role_slug: null,
  active: 0,
});

const submitted = ref(false);

onMounted(() => {
  formData.value.name = props.user?.name || '';
  formData.value.cpf = props.user?.cpf || '';
  formData.value.email = props.user?.email || '';
  formData.value.role = props.user?.roles?.[props.user.roles.length - 1] || null;
  formData.value.active = props.user?.active ? 1 : 0;
});

const onSubmit = async () => {
  submitted.value = true;
  emit('send', {
    email: formData.value.email,
    name: formData.value.name,
    cpf: formData.value.cpf,
    password: formData.value.password,
    role_id: formData.value.role?.id,
    role_slug: formData.value.role?.slug,
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
    <div class="row q-col-gutter-md">
      <div class="col-md-6">
        <label for="name" class="text-weight-bold">Nome</label>
        <q-input
          v-model="formData.name"
          filled
          placeholder="Digite o nome"
          lazy-rules
          :style="{ width: '100%' }"
          :rules="[(val) => (val && val.length > 0) || 'Por favor, insira o nome']" />
      </div>
      <div class="col-md-6">
        <label for="cpf" class="text-weight-bold">CPF</label>
        <q-input
          v-model="formData.cpf"
          filled
          placeholder="Digite o CPF"
          lazy-rules
          mask="###.###.###-##"
          :style="{ width: '100%' }"
          :rules="[(val) => (val && val.length > 0) || 'Por favor, insira o CPF']" />
      </div>
    </div>
    <div class="row q-col-gutter-md">
      <div class="col-md-12">
        <label for="email" class="text-weight-bold">Email</label>
        <q-input
          v-model="formData.email"
          filled
          type="email"
          placeholder="Digite o email"
          lazy-rules
          :style="{ width: '100%' }"
          :rules="[(val) => (val && val.length > 0) || 'Por favor, insira o email']" />
      </div>
    </div>
    <div class="row q-col-gutter-md">
      <div class="col-md-12">
        <label for="password" class="text-weight-bold">Senha</label>
        <q-input
          v-model="formData.password"
          filled
          label="Senha"
          type="password"
          placeholder="Digite a senha"
          lazy-rules
          :style="{ width: '100%' }"
          :rules="[]"
          :readonly="formData.send_random_password" />
      </div>
    </div>
    <div v-if="route.name !== 'editUsers'" class="row q-col-gutter-md">
      <div class="col-md-12">
        <q-checkbox
          v-model="formData.send_random_password"
          label="Enviar senha aleatória por email" />
      </div>
    </div>
    <div class="row q-col-gutter-md">
      <div class="col-md-6">
        <label for="role_id" class="text-weight-bold">Perfil</label>
        <q-select
          v-model="formData.role"
          :style="{ width: '100%' }"
          :options="props.profiles"
          option-label="name"
          option-value="id"
          filled
          label="Selecione um perfil"
          autofocus
          :rules="[
            (val) =>
              (submitted.value && val && (val.id || val.id === undefined)) ||
              !submitted.value ||
              'Por favor, selecione um perfil',
          ]">
          <template #no-option>
            <q-item>
              <q-item-section class="text-italic text-grey">
                Nenhuma opção disponível
              </q-item-section>
            </q-item>
          </template>
        </q-select>
      </div>
      <div class="col-md-6 d-flex align-items-end">
        <q-toggle
          v-model="formData.active"
          :true-value="1"
          :false-value="0"
          class="text-weight-bold"
          name="active"
          label="Ativo"
          :style="{ width: '100%' }"
          :rules="[
            (val) => val !== undefined || 'Por favor, selecione o status do usuário',
          ]" />
      </div>
    </div>
    <div class="q-mt-lg q-gutter-sm">
      <q-btn
        :loading="props.loading"
        class="text-weight-bold"
        label="Salvar"
        type="submit"
        color="secondary" />
      <q-btn
        flat
        class="text-weight-bold"
        label="Retornar"
        type="button"
        color="primary"
        :to="{ name: 'listUsers' }" />
    </div>
  </q-form>
</template>
