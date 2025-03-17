<script setup>
import useAuthenticate from '@/composables/Authenticate/useAuthenticate';
import { useQuasar } from 'quasar';
import { onMounted, ref, computed } from 'vue';
import { useRoute } from 'vue-router';
import AdminHeaderLayout from './AdminHeaderLayout.vue';
import AdminSidebar from './AdminSidebar.vue';
import logoImage from '@assets/logo-125px40px.png';

const drawer = ref(true);
const miniState = ref(false);
const route = useRoute();
const { myProfile } = useAuthenticate();
const $q = useQuasar();

const isMobile = computed(() => $q.screen.width <= 1024);

onMounted(async () => {
  await myProfile();
});
</script>

<template>
  <q-layout v-if="!isMobile" view="lHh Lpr lff" container class="layout__admin">
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

  <q-layout v-else
    view="hHh Lpr lff"
    container
    style="height: 300px"
    class="layout__admin header-mobile">
    <q-header elevated class="bg-white">
      <q-toolbar class="q-pl-sm q-pr-md">
        <img :src="logoImage" width="115px" />
        <q-toolbar-title class="text-dark flex flex-center q-pr-xl q-pt-xs">{{ route?.meta?.module }}</q-toolbar-title>
        <q-btn flat @click="drawer = !drawer" round dense icon="menu" class="text-dark"></q-btn>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="drawer"
      show-if-above
      :mini="miniState"
      @mouseenter="miniState = false"
      @mouseleave="miniState = true"
      mini-to-overlay
      :mini-width="120"
      :width="238"
      :breakpoint="500"
      bordered
      :class="$q.dark.isActive ? 'bg-primary' : 'bg-primary'">

      <AdminSidebar v-model:miniState="miniState" :isMobile="isMobile"></AdminSidebar>
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
