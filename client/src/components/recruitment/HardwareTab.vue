<script setup lang="ts">
import { RecruitmentList, FriendIdList, Friend, Hardware } from "@/types/game";
import { hardwareBcColor, hardwareTextColor, FRIENDID } from "@/store/common";

const emit = defineEmits<{
  (event: "change", hardware_id: number): void;
}>();

const changeHardware = (hardware_id: number) => {
  emit("change", hardware_id);
};

defineProps<{
  friendIdList: FriendIdList;
  hardware_list: Hardware;
  init_hardware_id2: number;
}>();
</script>

<template>
  <div class="grid grid-cols-5 gap-5 mt-5">
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
  </div>
</template>
