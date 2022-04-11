<script setup lang="ts">
import { ref, reactive, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import { getGame, postRecruitment } from "@/api/game";
import {
  RecruitmentPage,
  Hardware,
  PurposeList,
  RecruitmentList,
} from "@/types/game";
import RecruitmentForm from "@/components/recruitment/Form.vue";
import UserList from "@/components/recruitment/UserList.vue";

const router = useRouter();
const route = useRoute();

// const selectId = ref<number>();

// const game = ref<GameList>();
const state = reactive({
  game_id: 0,
  game_name: "",
  game_image_url: "",
  hardware_id: 0,
  hardware_name: "",
  hardwares: [] as Hardware[],
  purpose_list: [] as PurposeList[],
  recruitment_list: [] as RecruitmentList[],
  comment: "",
  init_hardware_id: 0,
  select_purpose_id: 0,
  is_ps: false,
  is_discord: false,
  is_friend_code: false,
  is_origin: false,
  is_skype: false,
  is_steam: false,
});

/**
 * フレンド募集 送信
 */
const recruitmentSubmit = async (
  comment: string,
  ps_id: string,
  steam_id: string,
  origin_id: string,
  skype_id: string,
  discord_id: string,
  friend_code_id: string
) => {
  const response = await postRecruitment(
    state.game_id,
    state.init_hardware_id,
    comment,
    ps_id,
    steam_id,
    origin_id,
    skype_id,
    discord_id,
    friend_code_id
  );
  // TODO: あらーとこんぽーねんと
  alert("掲示板へ書き込みました");
  // TODO: リロードなしでやりたい
  location.reload();
  // const routeId = route.params.id;
  // router.push(`/recruitment/${routeId}`);
  // router.go({ path: router.currentRoute.value });
};

/**
 * ゲーム一覧取得api
 */
const apiGetGame = async () => {
  const apiGame = await getGame(Number(route.params.id));
  state.game_id = apiGame.game.id;
  state.game_name = apiGame.game.game_name;
  state.game_image_url = apiGame.game.game_image_url;
  state.hardware_id = apiGame.game.hardware_id;
  state.hardware_name = apiGame.game.hardware_name;
  state.hardwares = apiGame.hardwares;
  state.recruitment_list = apiGame.recruitment_list;

  state.is_ps = Boolean(apiGame.game.is_ps);
  state.is_discord = Boolean(apiGame.game.is_discord);
  state.is_friend_code = Boolean(apiGame.game.is_friend_code);
  state.is_origin = Boolean(apiGame.game.is_origin);
  state.is_skype = Boolean(apiGame.game.is_skype);
  state.is_steam = Boolean(apiGame.game.is_steam);

  if (state.hardwares.length) {
    state.init_hardware_id = state.hardwares[0].hardware_id;
    console.log(state);
  }
};
apiGetGame();
</script>

<template>
  <div>
    <!-- <router-link :to="{ name: 'DashBoard' }" class="text-blue-500" -->
    <router-link to="/" class="text-blue-500">一覧ページへ</router-link>
  </div>
  <h1
    class="text-gray-800 text-2xl sm:text-3xl font-bold text-center mb-4 md:mb-6"
  >
    ({{ state.hardware_name }}) {{ state.game_name }}用 募集掲示板
  </h1>
  <!-- start -->
  <RecruitmentForm
    :hardwares="state.hardwares"
    :is_ps="state.is_ps"
    :is_discord="state.is_discord"
    :is_friend_code="state.is_friend_code"
    :is_origin="state.is_origin"
    :is_skype="state.is_skype"
    :is_steam="state.is_steam"
    @recruitment="recruitmentSubmit"
    v-model:selectHardwareId="state.init_hardware_id"
  />
  <!-- end -->

  <!-- start -->
  <UserList :recruitmentList="state.recruitment_list" />
  <!-- end -->
</template>
