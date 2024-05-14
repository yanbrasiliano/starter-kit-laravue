<script setup>
import { onMounted, ref } from 'vue';
import AdminSidebar from './AdminSidebar.vue';
import AdminHeaderLayout from './AdminHeaderLayout.vue';
import { useRoute } from 'vue-router';
import useAuthenticate from '@/composables/Authenticate/useAuthenticate';
import { useQuasar } from 'quasar';

const drawer = ref(true);
const miniState = ref(true);
const route = useRoute();
const { myProfile } = useAuthenticate();

onMounted(async () => {
  await myProfile();
});
const $q = useQuasar();

const icon = ref('chevron_left');
const offset = ref([-10, 0]);

function handleDrawer() {
  drawer.value = !drawer.value;
  icon.value = drawer.value ? 'chevron_left' : 'chevron_right';
  offset.value = drawer.value ? [-8, 2] : [10, 2];
}

</script>

<template>
  <q-layout view="lHh Lpr lff" container style="min-height: 100vh">
    <AdminHeaderLayout>
      <div v-if="route?.meta?.module && route?.meta?.icon" class="desktop-only">
        <span :style="{ fontSize: '20px', color: '#3B3B3B' }">
          <q-icon size="1.5em" :name="route?.meta?.icon" style="padding-bottom: 8px;"/>
          {{ route?.meta?.module }}
        </span>
      </div>
      
      <q-toolbar-title></q-toolbar-title>
    </AdminHeaderLayout>

    <q-drawer
      v-model="drawer"
      show-if-above      
      :mini="miniState"
      :width="300"
      bordered
      :class="$q.dark.isActive ? 'bg-primary' : 'bg-primary'"
      @mouseover="miniState = false"
      @mouseout="miniState = true">
      <AdminSidebar :mini-state="miniState"></AdminSidebar>
    </q-drawer>

    <q-page-container style="background-color: #eef0ff">
      <q-page padding class="q-mt-md">
        <router-view></router-view>
      </q-page>
      
    </q-page-container>
    <q-page-sticky v-if="!$q.screen.lt.md" position="top-left" :offset="offset" style="z-index: 2000">
      <q-btn
        color="secondary"
        round
        dense
        size="sm"
        :icon="icon"
        @click="handleDrawer" />
    </q-page-sticky>
  </q-layout>
</template>

<style scoped>
body {
  background-color: #eef0ff;
}
</style>
