<script setup lang="ts">
import { ref, computed } from "vue";
import Search from "@/components/form/Search.vue";
import GameList from "@/components/GameList.vue";
import { getGameList } from "@/api/game";
import { GameList as GameListType } from "@/types/game";
import RequestGameModal from "@/components/modal/RequestGameModal.vue";

const isModal = ref(false);

const showModal = () => {
  isModal.value = true;
};
const closeModal = () => {
  isModal.value = false;
};

const gameList = ref<GameListType[]>([]);
const hardwareList = ref<{ [key: string]: string }>();

/**
 * ゲーム一覧取得api
 */
const apiGetGameList = async () => {
  const apiGameList = await getGameList();
  gameList.value = apiGameList.game_list;
  hardwareList.value = apiGameList.hardware_master;
  // console.log(hardwareList.value);
};

apiGetGameList();
</script>

<template>
  <div class="mb-10">
    <!-- <h1
          class="text-gray-800 text-2xl sm:text-3xl font-bold text-center mb-4 md:mb-6"
        >
          こんにちは
        </h1> -->
    <h1 class="text-3xl font-bold mb-4">フレンド募集 ゲーム一覧</h1>
    <div>追加してほしいゲームがある場合はこちら</div>
    <button
      @click="showModal"
      class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white m-5 show-modal"
    >
      show modal
    </button>

    <transition name="fade">
      <RequestGameModal
        v-if="isModal"
        :hardwareList="hardwareList"
        @close="closeModal"
      />
    </transition>
    <Search />
  </div>
  <GameList :gameList="gameList" />
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
