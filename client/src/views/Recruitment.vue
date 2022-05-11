<script setup lang="ts">
import { ref, reactive, onMounted } from "vue";
import { useRoute } from "vue-router";
import { getGame, postRecruitment } from "@/api/game";
import {
  Hardware,
  PurposeList,
  RecruitmentList,
  FriendIdList,
  Friend,
} from "@/types/game";
import RecruitmentForm from "@/components/recruitment/Form.vue";
import UserList from "@/components/recruitment/UserList.vue";
// import Pagenation from "@/components/common/Pagenation.vue";
import HardwareTab from "@/components/recruitment/HardwareTab.vue";
import { useStore } from "@/store/index";
import * as MutationTypes from "@/store/mutationType";
import { SUCCESS_MSG } from "@/store/common";
import {
  setSessionStore,
  getSessionStore,
  removeSessionStore,
} from "@/store/storage";

const route = useRoute();
const store = useStore();

//ページネーションの設定
const pagenationData = reactive({
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
  hardware_list: {} as Hardware,
  friend_list: {} as Friend,
  purpose_list: [] as PurposeList[],
  recruitment_list: [] as RecruitmentList[],
  friend_id_list: {} as FriendIdList,
  comment: "",
  init_hardware_id: 0,
  init_hardware_id2: 0,
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
  setSessionStore(MutationTypes.INFO_FLASH_MSG, SUCCESS_MSG);
  // TODO: リロードなしでやりたい
  location.reload();
};

/**
 * 現在のページを設定して、api呼び出し
 * (ページネーション用)
 */
// const getCurrentPage = (currentPage: number) => {
//   pagenationData.currentPage = currentPage;
//   apiGetGame(state.init_hardware_id2);
// };

/**
 * ハードウェア変更して、api呼び出し
 */
const changeHardware = (hardware_id: number) => {
  pagenationData.currentPage = 1;
  state.init_hardware_id2 = hardware_id;
  apiGetGame(hardware_id);
};

const apiFlag = ref(false);

/**
 * ゲーム情報取得api
 */
const apiGetGame = async (hardware_id?: number) => {
  const apiGame = await getGame(
    Number(route.params.id),
    pagenationData.currentPage,
    hardware_id ?? ""
  );
  apiFlag.value = true;
  state.game_id = apiGame.game.id;
  state.game_name = apiGame.game.game_name;
  state.game_image_url = apiGame.game.game_image_url;
  // state.hardware_id = apiGame.game.hardware_id;
  // state.hardware_name = apiGame.game.hardware_name;
  state.hardware_list = apiGame.hardware_list;
  state.friend_list = apiGame.friend_list;
  state.recruitment_list = apiGame.recruitment_list;
  state.friend_id_list = apiGame.friend_id_list;

  console.log(state.recruitment_list);

  // if (state.recruitment_list.length) {
  //    = state.recruitment_list[0]['hardware_id']
  // }

  // pagenationData.totalCount = apiGame.page_data.total; // 総記事数
  // pagenationData.currentPage = apiGame.page_data.current_page; // 現在のページ
  // pagenationData.totalPages = apiGame.page_data.last_page; // 総ページ

  // state.is_ps = Boolean(apiGame.game.is_ps);
  // state.is_discord = Boolean(apiGame.game.is_discord);
  // state.is_friend_code = Boolean(apiGame.game.is_friend_code);
  // state.is_origin = Boolean(apiGame.game.is_origin);
  // state.is_skype = Boolean(apiGame.game.is_skype);
  // state.is_steam = Boolean(apiGame.game.is_steam);

  // ハードウェアの初期値設定
  if (state.friend_id_list) {
    for (const friendId in state.friend_id_list) {
      if (!state.init_hardware_id) {
        state.init_hardware_id = friendId as number;
      }
      if (!state.init_hardware_id2) {
        state.init_hardware_id2 = friendId as number;
      }
      break;
    }
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
  <div v-show="apiFlag">
    <h1
      class="text-gray-800 text-2xl sm:text-3xl font-bold text-center mb-4 md:mb-6"
    >
      <!-- ({{ state.hardware_name }}) {{ state.game_name }}用 募集掲示板 -->
      {{ state.game_name }}用 募集掲示板
    </h1>
    <!-- 応募フォーム -->
    <RecruitmentForm
      v-model:selectHardwareId="state.init_hardware_id"
      :friend-id-list="state.friend_id_list"
      :friend-list="state.friend_list"
      :hardware-list="state.hardware_list"
      @recruitment="recruitmentSubmit"
    />
    <!-- ハードウェアタブ -->
    <HardwareTab
      :friend-id-list="state.friend_id_list"
      :init-hardware-id2="state.init_hardware_id2"
      :hardware-list="state.hardware_list"
      @change="changeHardware"
    />
    <!-- ページネーション -->
    <!-- <Pagenation
      :showPages="pagenationData.showPages"
      :currentPage="pagenationData.currentPage"
      :totalCount="pagenationData.totalCount"
      :totalPages="pagenationData.totalPages"
      @currentPage="getCurrentPage"
    /> -->
    <!-- ユーザー情報 -->
    <UserList
      :recruitment-list="state.recruitment_list"
      :friend-id-list="state.friend_id_list"
      :friend-list="state.friend_list"
      :hardware_list="state.hardware_list"
      :init-hardware-id2="state.init_hardware_id2"
      @change="changeHardware"
    />
  </div>
</template>
