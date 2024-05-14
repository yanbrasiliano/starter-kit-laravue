<script setup>
import baseLayout from '@/assets/base-image.png';
</script>

<template>
  <div class="row">
    <section class="gt-xs col-sm-6 left-side-content-wrapper">
      <div class="layout-background">
        <q-img
          :src="baseLayout"
          style="max-width: 56vw; height: 56vw"
          alt="Layout Background"
          class="background-image" />
      </div>
    </section>
    <section
      class="col-xs-12 col-sm-6 q-pa-xl row justify-center items-center right-side-content-wrapper">
      <div class="right-side-content">
        <div class="text-headline1 q-mt-xl q-mb-md gt-xs">Access the platform</div>
        <p class="text-title2">Log in or sign up to get started</p>
        <div class="q-mt-xl q-mb-lg">
          <slot></slot>
        </div>
        <div class="text-title2"></div>
      </div>
    </section>
  </div>
</template>

<style scoped>
.layout-background {
  position: relative;
}

.welcome-message {
  position: absolute;
  bottom: 10%;
  left: 10%;
  color: white;
  font-size: 5em;
  z-index: 10;
}

.subtext {
  position: absolute;
  bottom: 3%;
  left: 10%;
  color: white;
  font-size: 2em;
  z-index: 10;
}

.right-side-content {
  width: 80%;
  max-width: 385px;
}

.right-side-content-wrapper {
  min-height: 100vh;
}

.left-side-content-wrapper {
  min-height: 100vh;
}
</style>
