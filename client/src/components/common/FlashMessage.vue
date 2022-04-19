<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useStore } from "@/store/index";
import * as MutationTypes from "@/store/mutationType";

const store = useStore();

/**
 * フラッシュメッセージ削除
 */
const delFlashMsg = () => {
  store.commit(MutationTypes.DEL_FLASH_MSG);
};
</script>

<template>
  <div
    v-show="store.state.flash_msg.is_display"
    class="fixed left-0 right-0 z-50 top-1"
  >
    <div
      class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800"
    >
      <div
        class="flex items-center justify-center w-12"
        :class="store.state.flash_msg.bg_color"
      >
        <svg
          class="w-6 h-6 text-white fill-current"
          viewBox="0 0 40 40"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path :d="store.state.flash_msg.image_path" />
        </svg>
      </div>

      <div class="px-4 py-4 -mx-3">
        <div class="mx-3">
          <span
            class="font-semibol"
            :class="store.state.flash_msg.text_color"
            >{{ store.state.flash_msg.message }}</span
          >
          <!-- <p class="text-sm text-gray-600 dark:text-gray-200">
            Your account was registered!
          </p> -->
        </div>
      </div>

      <div class="ml-auto my-auto pr-2">
        <button
          @click="delFlashMsg"
          class="p-1 transition-colors duration-200 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none"
        >
          <svg
            class="w-5 h-5"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M6 18L18 6M6 6L18 18"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>
