<script setup lang="ts">
import { ref, defineEmits, onMounted, toRefs, watch } from "vue";
import { Hardware } from "@/types/game";

const selectHardwareId = ref<number>(0);

const psId = ref<string>("");
const discordId = ref<string>("");
const friendCodeId = ref<string>("");
const originId = ref<string>("");
const skypeId = ref<string>("");
const steamId = ref<string>("");

const comment = ref<string>("");

interface Props {
  hardwares: Hardware[];
  is_ps: boolean;
  is_steam: boolean;
  is_origin: boolean;
  is_skype: boolean;
  is_discord: boolean;
  is_friend_code: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  is_ps: false,
  is_steam: false,
  is_origin: false,
  is_skype: false,
  is_discord: false,
  is_friend_code: false,
});

const emit = defineEmits<{
  (
    event: "recruitment",
    select_hardware_id: number,
    comment: string,
    ps_id: string,
    steam_id: string,
    origin_id: string,
    skype_id: string,
    discord_id: string,
    friend_code_id: string
  ): void;
}>();

// const setHardwareId = () => {
//   console.log(props.hardwares.length);
//   if (props.hardwares.length) {
//     console.log("入れます");
//     selectHardwareId.value = props.hardwares[0].hardware_id;
//   }
// };
// setHardwareId();

// const hardwares = toRefs(props);
// watch(checkHardwares, () => {
//   setHardwareId();
// });

const validate = () => {
  // if (!psId.value.length || !comment.value.length) {
  if (!comment.value.length) {
    alert("PSIDもしくはコメントを入力してください");
    return false;
  }
  return true;
};

const recruitmentSubmit = (): boolean | void => {
  if (!validate()) {
    return false;
  }
  emit(
    "recruitment",
    selectHardwareId.value,
    comment.value,
    psId.value,
    steamId.value,
    originId.value,
    skypeId.value,
    discordId.value,
    friendCodeId.value
  );
};
</script>

<template>
  <div class="p-5 rounded border bg-gray-300">
    <!-- <h1 class="font-medium text-3xl">Add User</h1> -->
    <!-- <p class="text-gray-600">募集する目的などを入力してください</p> -->

    <form @submit.prevent="recruitmentSubmit">
      <div>
        <div class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">機種</div>
          <select
            v-model.number="selectHardwareId"
            class="block appearance-none w-6/12 bg-white border border-gray-200 text-gray-700 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
          >
            <option
              v-for="(hardware, index) in hardwares"
              :key="index"
              :value="hardware.hardware_id"
              selected
            >
              {{ hardware.hardware_name }}
            </option>
          </select>
        </div>

        <!-- start -->
        <div v-if="props.is_ps" class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">PSID</div>
          <input
            v-model="psId"
            type="text"
            class="appearance-none block w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            placeholder="PSID"
          />
        </div>
        <div v-if="props.is_discord" class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">
            discordId
          </div>
          <input
            v-model="discordId"
            type="text"
            class="appearance-none block w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            placeholder="discordId"
          />
        </div>
        <div v-if="props.is_friend_code" class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">
            フレンドコード
          </div>
          <input
            v-model="friendCodeId"
            type="text"
            class="appearance-none block w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            placeholder="フレンドコード"
          />
        </div>
        <div v-if="props.is_origin" class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">
            originId
          </div>
          <input
            v-model="originId"
            type="text"
            class="appearance-none block w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            placeholder="originId"
          />
        </div>
        <div v-if="props.is_skype" class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">
            skypeId
          </div>
          <input
            v-model="skypeId"
            type="text"
            class="appearance-none block w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            placeholder="skypeId"
          />
        </div>
        <div v-if="props.is_steam" class="mb-3">
          <div class="text-sm text-gray-700 block mb-1 font-medium">
            steamId
          </div>
          <input
            v-model="steamId"
            type="text"
            class="appearance-none block w-6/12 bg-white text-gray-700 border border-gray-200 rounded px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            placeholder="steamId"
          />
        </div>
        <!-- end -->

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
        <button
          type="submit"
          class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 active:bg-blue-700 disabled:opacity-50"
        >
          募集する
        </button>
      </div>
    </form>
  </div>
</template>
