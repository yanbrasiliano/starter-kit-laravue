<template>
  <q-page class="q-pa-md">
    <q-card class="q-mb-md">
      <q-card-section class="text-h5"> Dashboard </q-card-section>
    </q-card>

    <q-card class="q-mb-md">
      <q-card-section>
        <div class="row">
          <q-card class="col q-pa-sm">
            <q-card-section class="text-h6 text-weight-bold"> Users </q-card-section>
            <q-card-section>
              <div class="row items-center">
                <q-icon name="people" class="q-mr-sm" size="32px" />
                <span class="text-h6">1234</span>
              </div>
            </q-card-section>
          </q-card>

          <q-card class="col q-pa-sm">
            <q-card-section class="text-h6 text-weight-bold"> Roles </q-card-section>
            <q-card-section>
              <div class="row items-center">
                <q-icon name="contacts" class="q-mr-sm" size="32px" />
                <span class="text-h6">10</span>
              </div>
            </q-card-section>
          </q-card>

          <q-card class="col q-pa-sm">
            <q-card-section class="text-h6 text-weight-bold"> Settings </q-card-section>
            <q-card-section>
              <div class="row items-center">
                <q-icon name="settings" class="q-mr-sm" size="32px" />
                <span class="text-h6">5</span>
              </div>
            </q-card-section>
          </q-card>
        </div>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup></script>

<style scoped>
.row {
  display: flex;
  justify-content: space-between;
}
.col {
  flex: 1;
  margin: 0 8px;
}
</style>
