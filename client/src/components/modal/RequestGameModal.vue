<script setup lang="ts">
import { ref } from "vue";
import { postRequestAddGameMail } from "@/api/game";
import { useStore } from "@/store/index";
import * as MutationTypes from "@/store/mutationType";
import { SUCCESS_MSG, GAME_NAME_ERR, CONFIRM } from "@/store/common";
import ConfirmModal from "@/components/modal/ConfirmModal.vue";

const game_name = ref("");
const select_hardware_id = ref([]);
const user_message = ref("");

const store = useStore();

defineProps<{
  hardwareList: {
    [key: string]: string;
  };
}>();

const emit = defineEmits<{
  (eventName: "close"): void;
}>();

const resetHardwareId = () => {
  select_hardware_id.value = [];
};

const validation = () => {
  if (!game_name.value) {
    return false;
  }
  return true;
};

/**
 * ゲーム追加のメールを送るapi
 */
const requestAddGameMail = async () => {
  store.commit(MutationTypes.IS_LOADING, true);
  const active_hardware_id = select_hardware_id.value.filter((id) => {
    return id !== null || id !== undefined;
  });
  await postRequestAddGameMail(
    game_name.value,
    active_hardware_id,
    user_message.value
  );
  store.commit(MutationTypes.IS_LOADING, false);
  emit("close");
  store.commit(MutationTypes.INFO_FLASH_MSG, SUCCESS_MSG);
};

// モーダル用
const is_display = ref(false);

/**
 * モーダル表示
 */
const showModal = () => {
  if (!validation()) {
    store.commit(MutationTypes.ERR_FLASH_MSG, GAME_NAME_ERR);
    return false;
  }
  is_display.value = true;
};

/**
 * モーダルOKの場合api叩く
 */
const modalConfirm = (is_result: boolean) => {
  is_display.value = false;
  if (is_result) {
    requestAddGameMail();
  }
};
</script>

<template>
  <div
    class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50 z-10"
  >
    <!-- modal -->
    <div class="bg-white rounded shadow-lg w-10/12 md:w-1/3">
      <!-- modal header -->
      <div class="border-b px-4 py-2 flex justify-between items-center">
        <h3 class="font-semibold text-lg">
          追加してほしいゲーム情報を入力してください
        </h3>
        <button @click="emit('close')" class="hover:bg-gray-300 p-1 rounded-md">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </div>
      <!-- modal body -->
      <div class="p-3">
        <div class="mb-3">
          <h3 class="font-bold">ゲーム名</h3>
          <input
            type="text"
            v-model="game_name"
            class="w-full"
            placeholder="ゲーム名"
          />
        </div>
        <div class="mb-3">
          <h3 class="font-bold">ハードウェア</h3>
          <li
            v-for="(hardware, key, index) in hardwareList"
            :key="key"
            class="list-none"
          >
            <input
              type="radio"
              :id="key"
              :value="key"
              v-model="select_hardware_id[index]"
            />
            <label :for="key">{{ hardware }}</label>
          </li>
          <button
            @click="resetHardwareId"
            class="bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-white mt-2"
          >
            クリア
          </button>
        </div>
        <div class="mb-3">
          <h3 class="font-bold">管理者へのメッセージ</h3>
          <textarea
            v-model="user_message"
            placeholder="管理者へのメッセージ"
            class="w-full h-25"
          ></textarea>
        </div>
      </div>
      <div class="flex justify-end items-center w-100 border-t p-3">
        <button
          class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white mr-3"
          @click="showModal"
        >
          <!-- <button
          class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white"
          @click="requestAddGameMail"
        > -->
          OK
        </button>
        <button
          @click="emit('close')"
          class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white"
        >
          Cancel
        </button>
        <ConfirmModal
          :is_display="is_display"
          @hideModal="modalConfirm"
          :message="CONFIRM"
        />
      </div>
    </div>
  </div>
</template>
