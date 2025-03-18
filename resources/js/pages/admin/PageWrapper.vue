<template>
  <div class="page-config">
    <slot name="title" />
    <q-card>
      <q-card-section>
        <slot name="actions" />
      </q-card-section>
      <q-card-section>
        <slot name="content" />
      </q-card-section>
    </q-card>
  </div>
</template>
