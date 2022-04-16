<script setup lang="ts">
import { ref } from "vue";
import { useStore } from "@/store/index";
import * as MutationTypes from "@/store/mutationType";

const store = useStore();

const display = ref(false);
const message = ref("");
const color = ref("");
const timeoutId = ref<number | null>(null);

/**
 * フラッシュメッセージ削除
 */
const delFlashMsg = () => {
  store.commit(MutationTypes.DEL_FLASH_MSG);
};
</script>

<template>
  <div class="fixed left-0 right-0 z-50 top-1">
    <div
      v-show="store.state.flash_msg.is_display"
      class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800"
    >
      <div class="flex items-center justify-center w-12 bg-emerald-500">
        <svg
          class="w-6 h-6 text-white fill-current"
          viewBox="0 0 40 40"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"
          />
        </svg>
      </div>

      <!-- <div class="px-4 py-2 -mx-3"> -->
      <div class="px-4 py-2 -mx-3">
        <div class="mx-3">
          <span class="font-semibold text-emerald-500 dark:text-emerald-400">{{
            store.state.flash_msg.message
          }}</span>
          <p class="text-sm text-gray-600 dark:text-gray-200">
            Your account was registered!
          </p>
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
