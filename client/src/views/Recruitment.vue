<script setup lang="ts">
import { ref, reactive, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import { getGame, postRecruitment } from "@/api/game";
import { Hardware, PurposeList, RecruitmentList } from "@/types/game";
import RecruitmentForm from "@/components/recruitment/Form.vue";
import UserList from "@/components/recruitment/UserList.vue";
import Pagenation from "@/components/common/Pagenation.vue";
import { useStore } from "@/store/index";
import * as MutationTypes from "@/store/mutationType";
import { SUCCESS_MSG } from "@/store/common";
import {
  setSessionStore,
  getSessionStore,
  removeSessionStore,
} from "@/store/storage";
import { remove } from "@vue/shared";

const router = useRouter();
const route = useRoute();
const store = useStore();

//ページネーションの設定
const pagenation_data = reactive({
  currentPage: 1, //現在のページ（初期は1）
  showPages: 5, //ページネーションを何ページ表示するか（奇数でないとずれる）
  keyword: "", // apiに渡すパラメータ
  totalCount: 0, //取得したアイテムの総件数
  totalPages: 0, //総ページ数
  // perPage: 3, //1ページの表示件数 (api側で設定)
});

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
  await postRecruitment(
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
  // store.commit(MutationTypes.INFO_FLASH_MSG, SUCCESS_MSG);
  setSessionStore(MutationTypes.INFO_FLASH_MSG, SUCCESS_MSG);
  // TODO: リロードなしでやりたい
  location.reload();
  // const routeId = route.params.id;
  // router.push(`/recruitment/${routeId}`);
  // router.go({ path: router.currentRoute.value });
};

/**
 * 現在のページを設定して、api呼び出し
 * (ページネーション用)
 */
const getCurrentPage = (currentPage: number) => {
  pagenation_data.currentPage = currentPage;
  apiGetGame();
};

const api_flag = ref(false);

/**
 * ゲーム情報取得api
 */
const apiGetGame = async () => {
  const apiGame = await getGame(
    Number(route.params.id),
    pagenation_data.currentPage
  );
  api_flag.value = true;
  state.game_id = apiGame.game.id;
  state.game_name = apiGame.game.game_name;
  state.game_image_url = apiGame.game.game_image_url;
  state.hardware_id = apiGame.game.hardware_id;
  state.hardware_name = apiGame.game.hardware_name;
  state.hardwares = apiGame.hardwares;
  state.recruitment_list = apiGame.recruitment_list;

  pagenation_data.totalCount = apiGame.page_data.total; // 総記事数
  pagenation_data.currentPage = apiGame.page_data.current_page; // 現在のページ
  pagenation_data.totalPages = apiGame.page_data.last_page; // 総ページ

  state.is_ps = Boolean(apiGame.game.is_ps);
  state.is_discord = Boolean(apiGame.game.is_discord);
  state.is_friend_code = Boolean(apiGame.game.is_friend_code);
  state.is_origin = Boolean(apiGame.game.is_origin);
  state.is_skype = Boolean(apiGame.game.is_skype);
  state.is_steam = Boolean(apiGame.game.is_steam);

  if (state.hardwares.length) {
    state.init_hardware_id = state.hardwares[0].hardware_id;
  }
};

/**
 * セッションメッセージがあれば表示
 */
const displayMessage = () => {
  const message = getSessionStore(MutationTypes.INFO_FLASH_MSG);
  if (message) {
    store.commit(MutationTypes.INFO_FLASH_MSG, SUCCESS_MSG);
    removeSessionStore(MutationTypes.INFO_FLASH_MSG);
  }
};

// ゲーム情報呼び出し
apiGetGame();

onMounted(() => {
  displayMessage();
});
</script>

<template>
  <!-- <router-link :to="{ name: 'DashBoard' }" class="text-blue-500" -->
  <router-link to="/" class="text-blue-500">一覧ページへ</router-link>
  <div v-show="api_flag">
    <h1
      class="text-gray-800 text-2xl sm:text-3xl font-bold text-center mb-4 md:mb-6"
    >
      ({{ state.hardware_name }}) {{ state.game_name }}用 募集掲示板
    </h1>
    <!-- 応募フォーム -->
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
    <!-- ページネーション -->
    <Pagenation
      :showPages="pagenation_data.showPages"
      :currentPage="pagenation_data.currentPage"
      :totalCount="pagenation_data.totalCount"
      :totalPages="pagenation_data.totalPages"
      @currentPage="getCurrentPage"
    />
    <!-- ユーザー情報 -->
    <UserList :recruitmentList="state.recruitment_list" />
  </div>
</template>
