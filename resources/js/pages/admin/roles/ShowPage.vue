<script setup>
import { onMounted, onUnmounted } from 'vue';
import useRoleStore from '@/store/useRoleStore';
import { useRoute } from 'vue-router';
import { useQuasar } from 'quasar';
import { storeToRefs } from 'pinia';

const store = useRoleStore();
const route = useRoute();
const $q = useQuasar();

const { role } = storeToRefs(useRoleStore());

onUnmounted(() => {
  store.resetStore();
});

onMounted(async () => {
  $q.loading.show();
  try {
    await store.fetchById(route.params.id);
  } finally {
    $q.loading.hide();
  }
});
</script>

<template>
  <div class="q-pa-md items-start q-gutter-md">
    <q-card>
      <q-card-section class="align-center">
        <div class="text-h6">User Role Details</div>
      </q-card-section>
      <q-card-section>
        <div class="text-h4">{{ role.name }}</div>
      </q-card-section>
      <q-separator inset />
      <q-card-section> <b>Description:</b> {{ role.description }} </q-card-section>
      <q-card-section> <b>Created on:</b> {{ store.getFormattedDate }} </q-card-section>
      <q-card-section>
        <b>Permissions:</b>
        <ul v-if="role.permissions.length > 0" class="rounded-borders">
          <li v-for="(permission, i) in role.permissions" :key="i" class="q-mb-sm">
            <span>{{ permission.label }}</span>
          </li>
        </ul>
        <span v-else>No permissions assigned</span>
      </q-card-section>
      <q-card-actions align="right">
        <q-btn flat label="Return" color="primary" :to="{ name: 'listRoles' }" />
      </q-card-actions>
    </q-card>
  </div>
</template>

<style scoped>
ul {
  padding: 0;
  list-style: none;
}
li {
  padding: 5px 0;
}
</style>
