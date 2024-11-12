<script setup></script>

<template>
  <main>
    <component :is="$route.meta.layout || 'div'">
      <RouterView></RouterView>
    </component>
  </main>
</template>

<style lang="sass">
@import '@css/app.sass'
</style>
