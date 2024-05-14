<script setup>
import useThematicAreaStore from "@/store/useThematicAreaStore";
import ErrorInput from "@components/shared/ErrorInput.vue";
import { storeToRefs } from 'pinia'
import { useQuasar } from "quasar";
import { onBeforeMount, onUnmounted } from "vue";
import { useRoute, useRouter } from 'vue-router';

const $q = useQuasar();
const { thematicArea, errors, loading, message, isSuccess } = storeToRefs(useThematicAreaStore());
const thematicAreaStore = useThematicAreaStore();
const { store, update } = thematicAreaStore;
const route = useRoute();
const router = useRouter();

onBeforeMount(async () => {
  thematicAreaStore.resetStore();
});

onUnmounted(() => {
  thematicAreaStore.resetStore();
});

async function onSave() {
  $q.loading.show();
  const params = getParams();
  
  if (route.params.id) {
    await update(route.params.id, params);
  } 
  else {
    await store(params);
  }
  $q.loading.hide();

  const color = isSuccess.value ? 'positive' : 'negative';
  $q.notify({ message: message.value, color, position: 'top-right'});

  if (isSuccess.value) {
    router.push({ name: "listThematicAreas" });
  }
}

function getParams() {
  return {
    description: thematicArea?.value.description,
  }
}

</script>

<template>
  <q-form v-if="thematicArea">
    <div>
      <label for="description" class="text-weight-bold">Descrição</label>
      <q-input
        v-model="thematicArea.description"
        filled
        placeholder="Digite a descrição"
        bottom-slots
        :error="errors && errors?.description?.length > 0"
      >
        <template #error>
          <ErrorInput :errors="errors.description"></ErrorInput>
        </template>
      </q-input>
    </div>
    <div class="q-mt-lg q-gutter-sm">
      <q-btn
        class="text-weight-bold"
        label="Salvar"
        type="submit"
        color="secondary"
        :loading="loading"
        @click.prevent="onSave()"
      />

      <q-btn
        flat
        class="text-weight-bold"
        label="Voltar"
        type="submit"
        color="primary"
        :to="{name: 'listThematicAreas'}"
      />
    </div>
  </q-form>
</template>
