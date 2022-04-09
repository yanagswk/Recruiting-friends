<script setup lang="ts">
import { ref, reactive, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { getGame, postRecruitment } from "@/api/game";
import { RecruitmentPage } from "@/types/game";

// const router = useRouter();
const route = useRoute();

const PS4PS5 = "3";

// const selectId = ref<number>();

// const game = ref<GameList>();
const state = reactive<RecruitmentPage>({
  game_id: 0,
  game_name: "",
  game_image_url: "",
  hardware_id: 0,
  hardware_name: "",
  hardwares: [],
  purpose_list: [],
  comment: "",
  psid: "",
  select_hardware_id: 0,
  select_purpose_id: 0,
});

const validate = () => {
  if (!state.psid.length || !state.comment.length) {
    alert("PSIDもしくはコメントを入力してください");
    return false;
  }
  return true;
};

const recruitmentSubmit = async () => {
  if (!validate()) {
    return false;
  }
  // alert("成功です");
  const response = await postRecruitment(
    state.game_id,
    state.comment,
    state.psid
  );
  console.log(response);
};

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
  state.purpose_list = apiGame.data.purpose_list;

  if (state.hardwares.length) {
    state.select_hardware_id = state.hardwares[0].hardware_id;
  }
  if (state.purpose_list.length) {
    state.select_purpose_id = state.purpose_list[0].purpose_id;
  }
};

onMounted(() => {
  apiGetGame();
});
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
  <div class="p-5 rounded border bg-gray-300">
    <!-- <h1 class="font-medium text-3xl">Add User</h1> -->
    <!-- <p class="text-gray-600">募集する目的などを入力してください</p> -->

    <form @submit.prevent="recruitmentSubmit">
      <!-- <div class="mt-3 grid lg:grid-cols-2 gap-4"> -->
      <div>
        <div class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">機種</div>
          <select
            v-model.number="state.select_hardware_id"
            class="block appearance-none w-6/12 bg-white border border-gray-200 text-gray-700 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          >
            <option
              v-for="(hardware, index) in state.hardwares"
              :key="index"
              :value="hardware.hardware_id"
            >
              {{ hardware.hardware_name }}
            </option>
          </select>
        </div>

        <!-- <div>
          <div class="text-sm text-gray-700 block mb-1 font-medium">目的</div>
          <select
            v-model.number="state.select_purpose_id"
            class="appearance-none w-6/12 bg-white border border-gray-200 text-gray-700 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          >
            <option
              v-for="(purpose, index) in state.purpose_list"
              :key="index"
              :value="purpose.purpose_id"
            >
              {{ purpose.purpose_name }}
            </option>
          </select>
        </div> -->

        <div class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">PSID</div>
          <input
            v-model="state.psid"
            type="text"
            class="appearance-none block w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            placeholder="PSID"
          />
        </div>

        <div class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">
            コメント
          </div>
          <textarea
            v-model="state.comment"
            class="bg-gray-100 border border-gray-200 rounded py-1 px-3 block text-gray-700 w-full"
            placeholder="コメント"
          >
          </textarea>
        </div>
      </div>

      <div class="mt-8">
        <button
          type="submit"
          class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 active:bg-blue-700 disabled:opacity-50"
        >
          募集する
        </button>
      </div>
    </form>
  </div>
  <!-- end -->
</template>
