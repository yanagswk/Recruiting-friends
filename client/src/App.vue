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
      <!-- <transition mode="out-in" name="web"> -->
      <!-- <keep-alive> -->
      <router-view></router-view>
      <!-- </keep-alive> -->
      <!-- </transition> -->
    </div>
  </div>
</template>

<style scoped>
/* .web-enter-from {
  transform: translate(-100px, 0);
  opacity: 0;
}
.web-enter-to {
  opacity: 1;
}
.web-enter-active {
  transition: all 1s 0s ease;
}
.web-leave {
  transform: translate(0, 0);
  opacity: 1;
}
.web-leave-to {
  transform: translate(100px, 0);
  opacity: 0;
}
.web-leave-active {
  transition: all 0.5s 0s ease;
} */

/* .web-enter-active,
.web-leave-active {
  transition: opacity 0.3s;
}
.web-enter-from,
.web-leave-to {
  opacity: 0;
} */

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
