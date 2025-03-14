<script setup>
import useAuthenticate from '@/composables/Authenticate/useAuthenticate';
import { useQuasar } from 'quasar';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import AdminHeaderLayout from './AdminHeaderLayout.vue';
import AdminSidebar from './AdminSidebar.vue';

const drawer = ref(true);
const miniState = ref(false);
const route = useRoute();
const { myProfile } = useAuthenticate();

onMounted(async () => {
  await myProfile();
});
const $q = useQuasar();
</script>

<template>
  <q-layout view="lHh Lpr lff" container style="height: 300px" class="layout__admin">
    <AdminHeaderLayout>
      <div v-if="route?.meta?.module && route?.meta?.icon" class="desktop-only">
        <span class="text-h4">
          {{ route?.meta?.module }}
        </span>
      </div>
      <q-toolbar-title></q-toolbar-title>
    </AdminHeaderLayout>

    <q-drawer
      v-model="drawer"
      show-if-above
      :mini="miniState"
      :mini-width="90"
      :width="238"
      bordered
      :breakpoint="400"
      @mouseover="miniState = miniState ? false : miniState"
      @mouseleave="miniState = drawer ? miniState : true"
      :class="$q.dark.isActive ? 'bg-primary' : 'bg-primary'">
      <AdminSidebar v-model:miniState="miniState"></AdminSidebar>
    </q-drawer>

    <q-page-container class="bg__grey--style">
      <q-page padding class="q-mt-md">
        <router-view></router-view>
      </q-page>
    </q-page-container>
  </q-layout>
</template>
<style lang="css">
@import '@css/admin.scss';
</style>
