<script setup lang="ts">
import Header from "@/components/common/Header.vue";
import Loading from "@/components/common/Loading.vue";
import FlashMessage from "@/components/common/FlashMessage.vue";
</script>

<template>
  <Loading />
  <transition name="popup">
    <FlashMessage />
  </transition>
  <Header />
  <div class="bg-white py-6 sm:py-8 lg:py-12">
    <div class="max-w-screen-md px-4 md:px-8 mx-auto">
      <router-view></router-view>
    </div>
  </div>
</template>

<style scoped>
/* .popup-enter-active,
.popup-leave-active {
  transform: translate(0px, 0px);
  transition: transform 225ms cubic-bezier(0, 0, 0.2, 1) 0ms;
}
.popup-enter-from,
.popup-leave-to {
  transform: translateY(-100vh) translateY(0px);
} */
.popup-enter-active,
.popup-leave-active {
  transition: opacity 0.3s;
}
.popup-enter-from,
.popup-leave-to {
  opacity: 0;
}
</style>
