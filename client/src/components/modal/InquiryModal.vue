<script setup lang="ts">
import { XIcon } from "@heroicons/vue/outline";

const emit = defineEmits<{
  (eventName: "close"): void;
}>();
</script>

<template>
  <div
    class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50 z-10"
  >
    <!-- modal -->
    <div class="bg-white rounded shadow-lg w-10/12 md:w-1/3">
      <div class="border-b px-4 py-2 flex justify-between items-center">
        <h3 class="font-semibold text-lg">管理者へのお問い合わせ</h3>
        <button class="hover:bg-gray-300 p-1 rounded-md" @click="emit('close')">
          <XIcon class="w-5 h-5" />
        </button>
      </div>
    </div>
  </div>
</template>
