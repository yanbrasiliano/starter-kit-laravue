<script setup>
import logoSmaller from '@assets/icons/logoSmaller-50px40px.png';
import logoImage from '@assets/logo-125px40px.png';
import { hasPermission } from '@utils/hasPermission';
import { isActiveLink } from '@utils/isActiveLink';
import { ROLE_PERMISSION, USER_PERMISSION } from '@utils/permissions';

const props = defineProps({
  miniState: Boolean,
});

const emit = defineEmits(['update:miniState']);
</script>

<template>
  <q-scroll-area class="sidebar-custom">
    <q-list padding class="q-mt-md">
      <q-item
        v-ripple
        clickable
        exact
        :to="{ name: 'adminHome' }"
        :class="isActiveLink('adminHome')">
        <q-item-section avatar class="text-white">
          <q-icon name="space_dashboard" />
        </q-item-section>
        <q-item-section class="text-white"> Dashboard </q-item-section>
      </q-item>
    </q-list>

    <q-list v-if="hasPermission([USER_PERMISSION.LIST, ROLE_PERMISSION.LIST])">
      <q-item
        v-if="hasPermission([USER_PERMISSION.LIST])"
        v-ripple
        clickable
        exact
        :to="{ name: 'listUsers' }"
        :class="isActiveLink('listUsers')">
        <q-item-section avatar class="text-white">
          <q-icon name="people_alt" />
        </q-item-section>
        <q-item-section class="text-white"> Usuários </q-item-section>
      </q-item>

      <q-item
        v-if="hasPermission([ROLE_PERMISSION.LIST])"
        v-ripple
        clickable
        exact
        :to="{ name: 'listRoles' }"
        :class="isActiveLink('listRoles')">
        <q-item-section avatar class="text-white">
          <q-icon name="contacts" />
        </q-item-section>
        <q-item-section class="text-white"> Perfis </q-item-section>
      </q-item>
    </q-list>
  </q-scroll-area>
  <div
    v-if="!props.miniState"
    class="logo__sidebar--active"
    style="top: 65px; left: 55px">
    <img :src="logoImage" width="124px" />
  </div>
  <div v-else class="logo__sidebar--inactive" style="top: 65px; left: 20px">
    <img :src="logoSmaller" width="50px" />
  </div>
  <div class="absolute" style="top: 80px; right: -11px">
    <q-btn
      round
      dense
      size="sm"
      unelevated
      color="secondary"
      :icon="props.miniState ? 'chevron_right' : 'chevron_left'"
      @click="emit('update:miniState', !props.miniState)"></q-btn>
  </div>
</template>
