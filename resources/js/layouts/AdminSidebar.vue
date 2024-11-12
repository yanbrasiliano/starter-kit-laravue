<script setup>
import logoImage from '@assets/logo-125px40px.png';
import logoSmaller from '@assets/icons/logoSmaller-50px40px.png';
import { isActiveLink } from '@utils/isActiveLink';
import { hasPermission } from '@utils/hasPermission';
import { USER_PERMISSION, ROLE_PERMISSION } from '@utils/permissions';

const props = defineProps({
  miniState: Boolean,
});
</script>

<template>
  <q-scroll-area
    style="height: calc(100% - 100px); margin-top: 70px; border-right: 1px solid #ddd">
    <q-list padding class="q-mt-md">
      <q-item v-show="!props.miniState">
        <q-item-label header class="text-white font-weight-bold text-uppercase">
          Administração
        </q-item-label>
      </q-item>

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
      <q-item v-show="!props.miniState">
        <q-item-label header class="text-white font-weight-bold text-uppercase">
          Gestão de acessos
        </q-item-label>
      </q-item>

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
  <div v-if="!props.miniState" class="logo__sidebar--active">
    <img :src="logoImage" width="124px" />
  </div>
  <div v-else class="logo__sidebar--inactive">
    <img :src="logoSmaller" width="50px" />
  </div>
</template>
