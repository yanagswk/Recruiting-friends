<script setup lang="ts">
import { ref } from "vue";

const game_name = ref("");
const select_hardware_id = ref([]);
const message = ref("");

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

const sendAddGameMail = () => {
  confirm("送信しますか？");
};
</script>

<template>
  <div
    class="modal h-screen w-full fixed left-0 top-0 flex justify-center items-center bg-black bg-opacity-50 z-20"
  >
    <!-- modal -->
    <div class="bg-white rounded shadow-lg w-10/12 md:w-1/3">
      <!-- modal header -->
      <div class="border-b px-4 py-2 flex justify-between items-center">
        <h3 class="font-semibold text-lg">
          追加してほしいゲーム情報を入力してください
        </h3>
        <button @click="emit('close')" class="text-black close-modal">
          &cross;
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
            v-model="message"
            placeholder="管理者へのメッセージ"
            class="w-full h-25"
          ></textarea>
        </div>
      </div>
      <div class="flex justify-end items-center w-100 border-t p-3">
        <button
          @click="emit('close')"
          class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white mr-1 close-modal"
        >
          Cancel
        </button>
        <button
          class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded text-white"
          @click="sendAddGameMail"
        >
          OK
        </button>
      </div>
    </div>
  </div>
</template>
