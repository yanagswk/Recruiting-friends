<script setup lang="ts">
import { ref } from "vue";
import { RecruitmentList } from "@/types/game";

const hardwareColor = {
  1: "bg-blue-500", // PS4
  2: "bg-indigo-600", // PS5
  4: "bg-red-500", // Swich
  5: "bg-green-500", // XboxOne
  6: "bg-yellow-500", // PC
};

defineProps<{
  recruitmentList: RecruitmentList[];
}>();
</script>

<template>
  <div
    class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8 mt-10"
  >
    <div
      v-for="recruitment in recruitmentList"
      :key="recruitment.id"
      class="flex flex-col items-center bg-gray-100 rounded-lg p-4 lg:p-6"
    >
      <div>
        <div class="text-xs mb-1">
          {{ recruitment.created_at }}
        </div>
        <!-- <div class="text-indigo-500 md:text-lg font-bold text-center"> -->
        <div
          class="rounded-full text-white px-3 py-1 text-xs font-medium text-center"
          :class="hardwareColor[recruitment.hardware_id]"
        >
          {{ recruitment.hardware_name }}
        </div>
        <!-- ハードウェア表示 -->
        <div class="mb-3">
          <div v-if="recruitment.ps_id">
            <span class="text-xs">PSID:</span
            ><span class="ml-1">{{ recruitment.ps_id }}</span>
          </div>
          <div v-if="recruitment.steam_id">
            <span class="text-xs">SteamID:</span
            ><span class="ml-1">{{ recruitment.steam_id }}</span>
          </div>
          <div v-if="recruitment.origin_id">
            <span class="text-xs">OriginID:</span
            ><span class="ml-1">{{ recruitment.origin_id }}</span>
          </div>
          <div v-if="recruitment.skype_id">
            <span class="text-xs">SkypeId:</span
            ><span class="ml-1">{{ recruitment.skype_id }}</span>
          </div>
          <div v-if="recruitment.discord_id">
            <span class="text-xs">DiscordID:</span
            ><span class="ml-1">{{ recruitment.discord_id }}</span>
          </div>
          <div v-if="recruitment.friend_code_id">
            <span class="text-xs">フレンドコード:</span
            ><span class="ml-1">{{ recruitment.friend_code_id }}</span>
          </div>
        </div>
        <p class="text-gray-500 text-sm md:text-base text-center mb-3 md:mb-4">
          {{ recruitment.comment }}
        </p>
      </div>
    </div>
  </div>
</template>
