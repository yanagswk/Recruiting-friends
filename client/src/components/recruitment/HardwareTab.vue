<script setup lang="ts">
import { FriendIdList, Hardware } from "@/types/game";
import { hardwareBcColor, hardwareTextColor } from "@/store/common";

const emit = defineEmits<{
  (event: "change", hardware_id: number): void;
}>();

const changeHardware = (hardware_id: number) => {
  emit("change", hardware_id);
};

defineProps<{
  friendIdList: FriendIdList;
  hardwareList: Hardware;
  initHardwareId2: number;
}>();
</script>

<template>
  <div class="grid grid-cols-5 gap-5 mt-5">
    <template v-for="(friend, index) in friendIdList" :key="index">
      <button
        v-if="initHardwareId2 == index"
        class="text-white p-3 rounded shadow-md font-medium"
        :class="hardwareBcColor[index]"
        @click="changeHardware(index)"
      >
        {{ hardwareList[index] }}
      </button>
      <button
        v-else
        class="p-3 rounded bg-white text-indigo-500 shadow-md font-medium"
        :class="hardwareTextColor[index]"
        @click="changeHardware(index)"
      >
        {{ hardwareList[index] }}
      </button>
    </template>
  </div>
</template>
