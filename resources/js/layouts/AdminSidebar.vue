<script setup>
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
        <q-item-label header class="text-white font-weight-bold">
          ADMINISTRATION
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
        <q-item-label header class="text-white font-weight-bold">
          ACCESS MANAGEMENT
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
        <q-item-section class="text-white"> Users </q-item-section>
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
        <q-item-section class="text-white"> Profiles </q-item-section>
      </q-item>
    </q-list>
  </q-scroll-area>
</template>

<style scoped>
.q-item__section--avatar {
  color: inherit;
  min-width: 0px !important;
}
</style>
