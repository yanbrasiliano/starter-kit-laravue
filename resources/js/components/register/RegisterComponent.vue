<script setup>
import baseLayout from '@/assets/base-image.png';
</script>

<template>
  <div class="row">
    <section class="gt-xs col-sm-6 left-side-content-wrapper">
      <div class="layout-background">
        <q-img
          :src="baseLayout"
          style="max-width: 56vw; height: 100%"
          alt="Layout Background"
          class="background-image" />
      </div>
    </section>
    <section class="col-xs-12 col-sm-6 q-pa-xl row justify-center">
      <div class="right-side-content">
        <div class="text-headline1 q-mt-xl q-mb-md gt-xs">Create Account</div>
        <p class="text-subtitle1">Sign up to get started</p>
        <div class="q-mt-xl q-mb-lg">
          <slot></slot>
        </div>
        <div class="text-center">
          <RouterLink to="/" class="link" color="primary">Back to login</RouterLink>
        </div>
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

.link {
  text-decoration: none;
  color: #0a64b7;
}
</style>
