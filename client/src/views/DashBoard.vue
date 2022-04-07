<script setup lang="ts">
import Search from "@/components/form/Search.vue";
import GameList from "@/components/GameList.vue";
</script>

<template>
  <div class="bg-white py-6 sm:py-8 lg:py-12">
    <div class="max-w-screen-md px-4 md:px-8 mx-auto">
      <div class="mb-10">
        <!-- <h1
          class="text-gray-800 text-2xl sm:text-3xl font-bold text-center mb-4 md:mb-6"
        >
          こんにちは
        </h1> -->
        <h1 class="text-2xl font-bold mb-4">フレンド募集 ゲーム一覧</h1>
        <Search />
      </div>
      <GameList />
    </div>
  </div>
</template>
