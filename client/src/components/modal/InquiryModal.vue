<script setup lang="ts">
import { ref } from "vue";
import { XIcon } from "@heroicons/vue/outline";
import ConfirmModal from "./ConfirmModal.vue";
import { CONFIRM, INQUIRY_ERR, SUCCESS_MSG } from "@/store/common";
import { useStore } from "@/store/index";
import * as MutationTypes from "@/store/mutationType";
import { postRequestInquiryMail } from "@/api/game";

const title = ref("");
const content = ref("");

const store = useStore();

const emit = defineEmits<{
  (eventName: "close"): void;
}>();

const validation = () => {
  if (!title.value && !content.value) {
    return false;
  }
  return true;
};

// モーダル用
const isDisplay = ref(false);
/**
 * モーダル表示
 */
const showModal = () => {
  if (!validation()) {
    store.commit(MutationTypes.ERR_FLASH_MSG, INQUIRY_ERR);
    return false;
  }
  isDisplay.value = true;
};
/**
 * モーダルOKの場合api叩く
 */
const modalConfirm = (is_result: boolean) => {
  isDisplay.value = false;
  if (is_result) {
    requestInquiryMail();
  }
};

const requestInquiryMail = async () => {
  store.commit(MutationTypes.IS_LOADING, true);
  console.log(title.value, content.value);
  await postRequestInquiryMail(title.value, content.value);
  store.commit(MutationTypes.IS_LOADING, false);
  emit("close");
  store.commit(MutationTypes.INFO_FLASH_MSG, SUCCESS_MSG);
};
</script>

<template>
  <div
    class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50 z-10"
  >
    <!-- modal -->
    <div class="bg-white rounded shadow-lg w-10/12 md:w-1/3">
      <div class="border-b px-4 py-2 flex justify-between items-center">
        <h3 class="font-semibold text-lg">管理者へのお問い合わせ</h3>
        <button class="hover:bg-gray-300 p-1 rounded-md" @click="emit('close')">
          <XIcon class="w-5 h-5" />
        </button>
      </div>
      <div class="p-3">
        <div class="mb-3">
          <h3 class="font-bold">タイトル</h3>
          <input
            v-model="title"
            type="text"
            class="w-full"
            placeholder="タイトル"
          />
        </div>
        <div class="mb-3">
          <h3 class="font-bold">お問い合わせ内容</h3>
          <textarea
            v-model="content"
            placeholder="管理者へのメッセージ"
            class="w-full h-40"
          ></textarea>
        </div>
      </div>
      <div class="flex justify-end items-center w-100 border-t p-3">
        <button
          class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white mr-3"
          @click="showModal"
        >
          OK
        </button>
        <button
          class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white"
          @click="emit('close')"
        >
          Cancel
        </button>
        <ConfirmModal
          :is-display="isDisplay"
          :message="CONFIRM"
          @hide-modal="modalConfirm"
        />
      </div>
    </div>
  </div>
</template>
