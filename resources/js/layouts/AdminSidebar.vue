<script setup>
import logoImage from '@assets/logo.svg';
import logoSmaller from '@assets/icons/logoSmaller.svg';
import { isActiveLink } from '@utils/isActiveLink';
import { hasPermission } from '@utils/hasPermission';
import {
  USER_PERMISSION,
  UNIT_PERMISSION,
  ROLE_PERMISSION,
  THEMATIC_AREA_PERMISSION,
  WORKPLAN_PERMISSION,
  ANNUAL_REPORT_PERMISSION,
  FREQUENCY_PERMISSION,
  REPORT_FILTERS_PERMISSION,
  ACCESS_HISTORY_PERMISSION,
  SETTINGS_PERMISSION,
  PROGRAMS_PERMISSION,
} from '@utils/permissions';

const props = defineProps({
  miniState: Boolean,
});
</script>
<template>
  <q-scroll-area
    style="height: calc(100% - 100px); margin-top: 70px; border-right: 1px solid #ddd">
    <q-list padding style="margin-top: 30px;">
      <q-item v-show="!props.miniState">
        <q-item-label header class="text-white font-weight-bold">
          ADMINISTRAÇÃO
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
        <q-item-section class="text-white"> Painel Inicial </q-item-section>
      </q-item>

      <q-item v-if="hasPermission([PROGRAMS_PERMISSION.LIST])" v-ripple clickable exact>
        <q-item-section avatar class="text-white">
          <q-icon name="description" />
        </q-item-section>
        <q-item-section class="text-white"> Programa | Projeto | Curso </q-item-section>
      </q-item>

      <q-item v-if="hasPermission([WORKPLAN_PERMISSION.LIST])" v-ripple clickable exact>
        <q-item-section avatar class="text-white">
          <q-icon name="library_books" />
        </q-item-section>
        <q-item-section class="text-white"> Plano de Trabalho </q-item-section>
      </q-item>

      <q-item v-if="hasPermission([ANNUAL_REPORT_PERMISSION.LIST])" v-ripple clickable exact>
        <q-item-section avatar class="text-white">
          <q-icon name="fact_check" />
        </q-item-section>
        <q-item-section class="text-white"> Relatório Anual </q-item-section>
      </q-item>

      <q-item v-if="hasPermission([REPORT_FILTERS_PERMISSION.LIST])" v-ripple clickable exact>
        <q-item-section avatar class="text-white">
          <q-icon name="list_alt" />
        </q-item-section>
        <q-item-section class="text-white"> Filtros de Relatórios </q-item-section>
      </q-item>

      <q-item v-if="hasPermission([FREQUENCY_PERMISSION.LIST])" v-ripple clickable exact>
        <q-item-section avatar class="text-white">
          <q-icon name="calendar_month" />
        </q-item-section>
        <q-item-section class="text-white"> Frequência </q-item-section>
      </q-item>

      <q-item
        v-if="hasPermission([THEMATIC_AREA_PERMISSION.LIST])"
        v-ripple
        clickable
        exact
        :to="{ name: 'listThematicAreas' }"
        :class="isActiveLink('listThematicAreas')">
        <q-item-section avatar class="text-white">
          <q-icon name="inventory" />
        </q-item-section>
        <q-item-section class="text-white"> Áreas Temáticas </q-item-section>
      </q-item>

      <q-item
        v-if="hasPermission([UNIT_PERMISSION.LIST])"
        v-ripple
        clickable
        :to="{ name: 'listUnits' }"
        exact
        :class="isActiveLink('listUnits')">
        <q-item-section avatar class="text-white">
          <q-icon name="account_balance" />
        </q-item-section>
        <q-item-section class="text-white"> Unidades </q-item-section>
      </q-item>
    </q-list>

    <q-list
      v-if="hasPermission([USER_PERMISSION.LIST, ROLE_PERMISSION.LIST, ACCESS_HISTORY_PERMISSION.LIST, SETTINGS_PERMISSION.LIST])">
      <q-item v-show="!props.miniState">
        <q-item-label header class="text-white font-weight-bold">
          GESTÃO DE ACESSOS
        </q-item-label>
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
        <q-item-section class="text-white"> Perfís de Acesso </q-item-section>
      </q-item>

      <q-item
        v-if="hasPermission([USER_PERMISSION.LIST])"
        v-ripple
        clickable
        :to="{ name: 'listUsers' }"
        exact
        :class="isActiveLink('listUsers')">
        <q-item-section avatar class="text-white">
          <q-icon name="people_alt" />
        </q-item-section>
        <q-item-section class="text-white"> Usuários </q-item-section>
      </q-item>

      <q-item v-if="hasPermission([ACCESS_HISTORY_PERMISSION.LIST])" v-ripple clickable exact>
        <q-item-section avatar class="text-white">
          <q-icon name="find_in_page" />
        </q-item-section>
        <q-item-section class="text-white"> Histórico de Acessos </q-item-section>
      </q-item>

      <q-item v-if="hasPermission([SETTINGS_PERMISSION.LIST])" v-ripple clickable exact>
        <q-item-section avatar class="text-white">
          <q-icon name="settings" />
        </q-item-section>
        <q-item-section class="text-white"> Configurações </q-item-section>
      </q-item>
    </q-list>
  </q-scroll-area>
  <div v-if="!props.miniState" style="top: 15px; left: 35px; position: absolute">
    <img :src="logoImage" width="124px" />
  </div>
  <div v-else style="top: 15px; left: 5px; position: absolute">
    <img :src="logoSmaller" width="50px" />
  </div>
</template>
<style scoped>
.q-item__section--avatar {
  color: inherit;
  min-width: 0px !important;
}
</style>
