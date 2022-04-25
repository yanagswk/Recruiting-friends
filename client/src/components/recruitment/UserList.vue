<script setup lang="ts">
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
        <!-- <div class="text-indigo-500 md:text-lg font-bold text-center"> -->
        <div
          class="rounded-full text-white px-3 py-1 text-xs font-medium w-4/5 mx-auto"
          :class="hardwareColor[recruitment.hardware_id]"
        >
          {{ recruitment.hardware_name }}
        </div>
        <!-- ハードウェア表示 -->
        <div class="my-3">
          <div v-if="recruitment.ps_id">
            <div class="text-xs">PSID</div>
            <div class="font-medium break-words">
              {{ recruitment.ps_id }}
            </div>
          </div>
          <div v-if="recruitment.steam_id">
            <div class="text-xs">SteamID</div>
            <div class="font-medium break-words">
              {{ recruitment.steam_id }}
            </div>
          </div>
          <div v-if="recruitment.origin_id">
            <div class="text-xs">OriginID</div>
            <div class="font-medium break-words">
              {{ recruitment.origin_id }}
            </div>
          </div>
          <div v-if="recruitment.skype_id">
            <div class="text-xs">SkypeId</div>
            <div class="font-medium break-words">
              {{ recruitment.skype_id }}
            </div>
          </div>
          <div v-if="recruitment.discord_id">
            <div class="text-xs">DiscordID</div>
            <div class="font-medium break-words">
              {{ recruitment.discord_id }}
            </div>
          </div>
          <div v-if="recruitment.friend_code_id">
            <div class="text-xs">フレンドコード</div>
            <div class="font-medium break-words">
              {{ recruitment.friend_code_id }}
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
