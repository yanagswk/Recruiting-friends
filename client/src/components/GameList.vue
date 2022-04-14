<script setup lang="ts">
import { onMounted, ref } from "vue";
import { getGameList } from "@/api/game";
import { GameList } from "@/types/game";

// const gameList = ref<GameList[]>([]);

defineProps<{
  gameList: GameList[];
}>();

/**
 * ゲーム一覧取得api
 */
// const apiGetGameList = async () => {
//   const apiGameList = await getGameList();
//   gameList.value = apiGameList.game_list;
// };

// apiGetGameList();
</script>

<template>
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8">
    <div
      v-for="(game, index) in gameList"
      :key="index"
      class="flex flex-col items-center bg-gray-100 rounded-lg p-4 lg:p-8"
    >
      <div
        class="w-24 md:w-32 h-24 md:h-32 bg-gray-200 rounded-full overflow-hidden shadow-lg mb-2 md:mb-4"
      >
        <img
          :src="game.game_image_url"
          loading="lazy"
          alt="ゲームイメージ"
          class="w-full h-full object-cover object-center"
        />
      </div>
      <div>
        <div class="text-indigo-500 md:text-lg font-bold text-center">
          <router-link :to="{ name: 'Recruitment', params: { id: game.id } }">
            {{ game.game_name }}
          </router-link>
        </div>
        <p class="text-gray-500 text-sm md:text-base text-center mb-3 md:mb-4">
          {{ game.hardware_name }}
        </p>
      </div>
    </div>
  </div>
</template>
