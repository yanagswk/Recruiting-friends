<script setup lang="ts">
import { ref } from "vue";
import { Hardware, FriendIdList, Friend } from "@/types/game";
import { useStore } from "@/store/index";
import * as MutationTypes from "@/store/mutationType";
import { COMMENT_ERR, CONFIRM, FRIENDID } from "@/store/common";
import ConfirmModal from "@/components/modal/ConfirmModal.vue";
// import _ from "lodash";

const psId = ref("");
const discordId = ref("");
const friendCodeId = ref("");
const originId = ref("");
const skypeId = ref("");
const steamId = ref("");
const comment = ref("");

const store = useStore();

defineProps<{
  hardwareList: Hardware;
  friendList: Friend;
  friendIdList: FriendIdList;
  selectHardwareId: number;
}>();

const emit = defineEmits<{
  (
    event: "recruitment",
    comment: string,
    ps_id: string,
    steam_id: string,
    origin_id: string,
    skype_id: string,
    discord_id: string,
    friend_code_id: string
  ): void;
  (event: "update:selectHardwareId", test_select_hardware_id: number): void;
}>();

const recruitmentSubmit = (): boolean | void => {
  emit(
    "recruitment",
    comment.value,
    psId.value,
    steamId.value,
    originId.value,
    skypeId.value,
    discordId.value,
    friendCodeId.value
  );
};

// モーダル用
const isDisplay = ref(false);

/**
 * モーダルOKの場合は募集送信
 */
const modalConfirm = (is_result: boolean) => {
  isDisplay.value = false;
  if (is_result) {
    recruitmentSubmit();
  }
};

/**
 * バリデーション
 */
const validate = () => {
  // TODO: id系のバリデーション
  if (!comment.value) {
    return false;
  }
  return true;
};

/**
 * モーダル表示
 */
const showModal = () => {
  if (!validate()) {
    store.commit(MutationTypes.ERR_FLASH_MSG, COMMENT_ERR);
    return false;
  }
  isDisplay.value = true;
};

/**
 * 機種のセレクトボタン検知
 */
const changeHardwareId = (e: Event) => {
  const target = e.target as HTMLInputElement;
  emit("update:selectHardwareId", Number(target.value));
};
</script>

<template>
  <div class="p-5 rounded border bg-gray-300">
    <!-- <h1 class="font-medium text-3xl">Add User</h1> -->
    <!-- <p class="text-gray-600">募集する目的などを入力してください</p> -->

    <!-- <form @submit.prevent="recruitmentSubmit"> -->
    <form>
      <div>
        <div class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">機種</div>
          <select
            class="block appearance-none w-6/12 bg-white border border-gray-200 text-gray-700 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            :value="selectHardwareId"
            @change="changeHardwareId"
          >
            <option
              v-for="(hardware, index) in friendIdList"
              :key="index"
              :value="index"
            >
              {{ hardwareList[index] }}
            </option>
          </select>
        </div>

        <template
          v-for="(friend_id, index) in friendIdList[selectHardwareId]"
          :key="index"
        >
          <div v-if="friend_id == FRIENDID.PSID" class="mb-3">
            <div class="text-sm text-gray-700 block mb-1 font-medium">PSID</div>
            <input
              v-model="psId"
              type="text"
              class="appearance-none block placeholder:text-xs placeholder:text-gray-400 w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              placeholder="PSID"
            />
          </div>
          <div v-if="friend_id == FRIENDID.DISCORDID" class="mb-3">
            <div class="text-sm text-gray-700 block mb-1 font-medium">
              discordId
            </div>
            <input
              v-model="discordId"
              type="text"
              class="appearance-none block placeholder:text-xs placeholder:text-gray-400 w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              placeholder="discordId"
            />
          </div>
          <div v-if="friend_id == FRIENDID.FRIENDCODE" class="mb-3">
            <div class="text-sm text-gray-700 block mb-1 font-medium">
              フレンドコード
            </div>
            <input
              v-model="friendCodeId"
              type="text"
              class="appearance-none block placeholder:text-xs placeholder:text-gray-400 w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              placeholder="フレンドコード"
            />
          </div>
          <div v-if="friend_id == FRIENDID.ORIGINID" class="mb-3">
            <div class="text-sm text-gray-700 block mb-1 font-medium">
              originId
            </div>
            <input
              v-model="originId"
              type="text"
              class="appearance-none block placeholder:text-xs placeholder:text-gray-400 w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              placeholder="originId"
            />
          </div>
          <div v-if="friend_id == FRIENDID.SKYPEID" class="mb-3">
            <div class="text-sm text-gray-700 block mb-1 font-medium">
              skypeId
            </div>
            <input
              v-model="skypeId"
              type="text"
              class="appearance-none block placeholder:text-xs placeholder:text-gray-400 w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              placeholder="skypeId"
            />
          </div>
          <div v-if="friend_id == FRIENDID.STEAMID" class="mb-3">
            <div class="text-sm text-gray-700 block mb-1 font-medium">
              steamId
            </div>
            <input
              v-model="steamId"
              type="text"
              class="appearance-none block placeholder:text-xs placeholder:text-gray-400 w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              placeholder="steamId"
            />
          </div>
        </template>

        <div class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">
            コメント
          </div>
          <textarea
            v-model="comment"
            class="bg-gray-100 border border-gray-200 rounded py-1 px-3 block text-gray-700 w-full"
            placeholder="コメント"
          >
          </textarea>
        </div>
      </div>

      <div class="mt-8">
        <!-- type="submit" -->
        <button
          class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 active:bg-blue-700 disabled:opacity-50"
          type="button"
          @click="showModal()"
        >
          募集する
        </button>
        <ConfirmModal
          :is-display="isDisplay"
          :message="CONFIRM"
          @hide-modal="modalConfirm"
        />
      </div>
    </form>
  </div>
</template>
