<script setup>
import PageWrapper from '@/pages/admin/PageWrapper.vue';

const userCount = 1234;
const profileCount = 10;
</script>

<template>
  <PageWrapper>
    <template #title>
      <q-card class="q-mb-md">
        <q-card-section class="text-h5"> Dashboard </q-card-section>
      </q-card>
    </template>

    <template #content>
      <q-card-section>
        <div class="row q-gutter-md">
          <q-card class="col q-pa-sm">
            <q-card-section class="text-h6 text-weight-bold"> Usuários </q-card-section>
            <q-card-section>
              <div class="row items-center">
                <q-icon name="people" class="q-mr-sm" size="32px" />
                <span class="text-h6">{{ userCount }}</span>
              </div>
            </q-card-section>
          </q-card>

          <q-card class="col q-pa-sm">
            <q-card-section class="text-h6 text-weight-bold"> Perfis </q-card-section>
            <q-card-section>
              <div class="row items-center">
                <q-icon name="contacts" class="q-mr-sm" size="32px" />
                <span class="text-h6">{{ profileCount }}</span>
              </div>
            </q-card-section>
          </q-card>
        </div>
      </q-card-section>
    </template>
  </PageWrapper>
</template>
