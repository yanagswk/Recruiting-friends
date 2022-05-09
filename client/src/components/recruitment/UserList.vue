<script setup lang="ts">
import { RecruitmentList, FriendIdList, Friend, Hardware } from "@/types/game";
import { hardwareBcColor, hardwareTextColor, FRIENDID } from "@/store/common";

defineProps<{
  recruitmentList: RecruitmentList[];
  friendIdList: FriendIdList;
  friendList: Friend;
  hardware_list: Hardware;
  init_hardware_id2: number;
}>();

// const emit = defineEmits<{
//   (event: "change", hardware_id: number): void;
// }>();

// const changeHardware = (hardware_id: number) => {
//   emit("change", hardware_id);
// };
</script>

<template>
  <!-- <div class="grid grid-cols-5 gap-5 mt-5">
    <template v-for="(friend, index) in friendIdList" :key="index">
      <button
        v-if="init_hardware_id2 == index"
        class="text-white p-3 rounded shadow-md font-medium"
        :class="hardwareBcColor[index]"
        @click="changeHardware(index)"
      >
        {{ hardware_list[index] }}
      </button>
      <button
        v-else
        class="p-3 rounded bg-white text-indigo-500 shadow-md font-medium"
        :class="hardwareTextColor[index]"
        @click="changeHardware(index)"
      >
        {{ hardware_list[index] }}
      </button>
    </template>
  </div> -->
  <!-- <div
    class="shadow-xl border border-gray-100 font-light p-8 rounded text-gray-500 bg-white mt-6"
  >
    Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt
    tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor,
    williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh
    dreamcatcher synth.
  </div> -->

  <div
    class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8 mt-5"
  >
    <div
      v-for="recruitment in recruitmentList"
      :key="recruitment.id"
      class="flex flex-col bg-gray-100 rounded-lg p-3"
    >
      <div class="text-xs mb-2">
        {{ recruitment.created_at }}
      </div>
      <div class="text-center">
        <div
          class="rounded-full text-white px-3 py-1 text-xs font-medium w-4/5 mx-auto"
          :class="hardwareBcColor[recruitment.hardware_id]"
        >
          {{ recruitment.hardware_name }}
        </div>

        <!-- ハードウェア表示 -->
        <div
          v-for="friend in recruitment.friend_name_list"
          :key="friend.hardware_friend_id"
          class="my-3"
        >
          <div v-if="friend.hardware_friend_id === FRIENDID.PSID">
            <div class="text-xs">PSID</div>
            <div class="font-medium break-words">
              {{ friend.friend_name }}
            </div>
          </div>
          <div v-if="friend.hardware_friend_id === FRIENDID.ORIGINID">
            <div class="text-xs">OriginID</div>
            <div class="font-medium break-words">
              {{ friend.friend_name }}
            </div>
          </div>
          <div v-if="friend.hardware_friend_id === FRIENDID.SKYPEID">
            <div class="text-xs">SkypeId</div>
            <div class="font-medium break-words">
              {{ friend.friend_name }}
            </div>
          </div>
          <div v-if="friend.hardware_friend_id === FRIENDID.DISCORDID">
            <div class="text-xs">DiscordID</div>
            <div class="font-medium break-words">
              {{ friend.friend_name }}
            </div>
          </div>
          <div v-if="friend.hardware_friend_id === FRIENDID.STEAMID">
            <div class="text-xs">SteamID</div>
            <div class="font-medium break-words">
              {{ friend.friend_name }}
            </div>
          </div>
          <div v-if="friend.hardware_friend_id === FRIENDID.FRIENDCODE">
            <div class="text-xs">フレンドコード</div>
            <div class="font-medium break-words">
              {{ friend.friend_name }}
            </div>
          </div>
        </div>

        <p
          class="text-gray-600 text-sm md:text-base mb-3 md:mb-4 p-1 bg-slate-200 break-words"
        >
          {{ recruitment.comment }}
        </p>
      </div>
    </div>
  </div>
</template>
