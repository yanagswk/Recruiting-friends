<script setup lang="ts">
import { ref, reactive, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import { getGame, postRecruitment } from "@/api/game";
import { RecruitmentPage, Hardware, PurposeList } from "@/types/game";
import RecruitmentForm from "@/components/recruitment/Form.vue";

// const router = useRouter();
const route = useRoute();

const PS4PS5 = "3";

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
  comment: "",
  select_hardware_id: 0,
  select_purpose_id: 0,
  is_ps: false,
  is_discord: false,
  is_friend_code: false,
  is_origin: false,
  is_skype: false,
  is_steam: false,
});

const recruitmentSubmit = async (
  hardware_id: number,
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
    hardware_id,
    comment,
    ps_id,
    steam_id,
    origin_id,
    skype_id,
    discord_id,
    friend_code_id
  );
  console.log(response);
};

// const needRecruitmentIdMethod = () => {
//   const needRecruitmentId = [];
//   Object.keys(state.recruitment_id_list).forEach(function (key) {
//     if (state.recruitment_id_list[key] === true) {
//       needRecruitmentId.push(key);
//     }
//   });
//   return needRecruitmentId;
// };

/**
 * ゲーム一覧取得api
 */
const apiGetGame = async () => {
  const apiGame = await getGame(Number(route.params.id));
  // game.value = apiGame.data.game;
  console.log(apiGame);
  state.game_id = apiGame.data.game.id;
  state.game_name = apiGame.data.game.game_name;
  state.game_image_url = apiGame.data.game.game_image_url;
  state.hardware_id = apiGame.data.game.hardware_id;
  state.hardware_name = apiGame.data.game.hardware_name;
  state.hardwares = apiGame.data.hardwares;
  // state.purpose_list = apiGame.data.purpose_list;

  state.is_ps = Boolean(apiGame.data.game.is_ps);
  state.is_discord = Boolean(apiGame.data.game.is_discord);
  state.is_friend_code = Boolean(apiGame.data.game.is_friend_code);
  state.is_origin = Boolean(apiGame.data.game.is_origin);
  state.is_skype = Boolean(apiGame.data.game.is_skype);
  state.is_steam = Boolean(apiGame.data.game.is_steam);

  if (state.hardwares.length) {
    state.select_hardware_id = state.hardwares[0].hardware_id;
  }
  // if (state.purpose_list.length) {
  //   state.select_purpose_id = state.purpose_list[0].purpose_id;
  // }
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
  />
  <!-- end -->
  <div>text</div>
</template>
