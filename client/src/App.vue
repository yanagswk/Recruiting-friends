<script setup lang="ts">
import DefaultBar from "./layouts/DefaultBar.vue";
</script>

<template>
  <DefaultBar />
  <div class="bg-white py-6 sm:py-8 lg:py-12">
    <div class="max-w-screen-md px-4 md:px-8 mx-auto">
      <router-view></router-view>
    </div>
  </div>
</template>
