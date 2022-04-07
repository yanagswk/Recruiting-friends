<script setup lang="ts">
import DropdownMenu from "@/components/DropdownMenu.vue";
</script>

<template>
  <div class="relative">
    <div
      class="flex items-center justify-between bg-red-500 rounded shadow p-2"
    >
      <!-- <MenuIcon
          class="h-6 w-6 text-gray-600 dark:text-gray-300 cursor-pointer"
          @click="show = !show"
        /> -->
      <div>ゆるボ！</div>
      <div class="flex items-center space-x-4">
        <DropdownMenu />
      </div>
    </div>
    <div class="dark:text-gray-300">
      <!-- サイドバー -->
      <slot />
    </div>
    <!-- </div> -->
  </div>
</template>
