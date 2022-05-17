<script setup lang="ts">
import { ref } from "vue";
import { MailIcon } from "@heroicons/vue/outline";
import InquiryModal from "@/components/modal/InquiryModal.vue";

const isModal = ref(false);

const showModal = () => {
  isModal.value = true;
};

const closeModal = () => {
  isModal.value = false;
};
</script>

<template>
  <div class="relative">
    <div
      class="flex items-center justify-between bg-red-500 rounded shadow test"
    >
      <!-- <MenuIcon
          class="h-6 w-6 text-gray-600 dark:text-gray-300 cursor-pointer"
          @click="show = !show"
        /> -->
      <div class="pl-6 flex items-center text-white p-2">
        <div class="text-2xl">ゆるボ！</div>
        <div class="pl-2">～ゆるっとフレンド募集掲示板～</div>
      </div>
      <!-- <div>test</div> -->
      <div
        class="flex items-center space-x-4 text-white mr-6 p-3 cursor-pointer hover:bg-red-600 h-full"
        @click="showModal"
      >
        <!-- <DropdownMenu /> -->
        <MailIcon class="w-5 h-5 mr-1" />
        問い合わせ
      </div>
    </div>
    <div class="dark:text-gray-300">
      <!-- サイドバー -->
      <slot />
    </div>
    <!-- </div> -->
    <transition name="fade">
      <InquiryModal v-if="isModal" @close="closeModal" />
    </transition>
  </div>
</template>

<style scoped>
/* .testn {
  @apply flex items-center justify-between bg-red-500 rounded shadow p-2;
} */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
