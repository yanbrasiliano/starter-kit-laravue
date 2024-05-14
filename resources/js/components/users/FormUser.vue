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
  formData.value.name = props.user?.name;
  formData.value.cpf = props.user?.cpf;
  formData.value.email = props.user?.email;
  formData.value.role = props.user?.roles[props.user.roles.length - 1];
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
  <q-form class="q-gutter-md" @submit="onSubmit">
    <div>
      <label for="name" class="text-weight-bold">Nome</label>
      <q-input
        v-model="formData.name"
        filled
        placeholder="Digite o nome"
        lazy-rules
        autofocus
        :rules="[(val) => (val && val.length > 0) || 'Por favor insira o nome']" />
    </div>
    <div>
      <label for="email" class="text-weight-bold">E-mail</label>
      <q-input
        v-model="formData.email"
        filled
        type="email"
        placeholder="Digite o seu e-mail"
        lazy-rules
        autofocus
        :rules="[(val) => (val && val.length > 0) || 'Por favor insira o seu e-mail']" />
    </div>
    <div>
      <label for="password" class="text-weight-bold">Senha</label>
      <q-input
        v-model="formData.password"
        filled
        label="Senha"
        type="password"
        placeholder="Digite sua senha"
        lazy-rules
        autofocus
        :rules="[]"
        :readonly="formData?.send_random_password" />
    </div>
    <div v-if="route.name != 'editUsers'">
      <q-checkbox
        v-model="formData.send_random_password"
        label="Enviar senha aleatória por e-mail" />
    </div>
    <div class="row">
      <div class="col-md-6">
        <label for="role_id" class="text-weight-bold">Perfil</label>
        <q-select
          v-model="formData.role"
          :style="{ width: '100%', minWidth: '200px' }"
          :options="props.profiles"
          option-label="name"
          option-value="id"
          filled
          label="Selecione um perfil"
          autofocus
          :rules="[
            (val) =>
              (val && (val.id || val.id == undefined)) || 'Por favor selecione um perfil',
          ]">
          <template #no-option>
            <q-item>
              <q-item-section class="text-italic text-grey">
                Nenhuma opção disponivel
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
          label="Ativo"
          autofocus
          :rules="[
            (val) =>
              (val && val.length > 0) || 'Por favor selecione a situação do usuário',
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
        label="Voltar"
        type="submit"
        color="primary"
        :loading="loading"
        :to="{name: 'listUsers'}"
      />
    </div>
    
  </q-form>
</template>
