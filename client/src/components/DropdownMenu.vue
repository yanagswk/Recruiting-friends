<script setup lang="ts">
import { ref, onMounted, onUnmounted } from "vue";
import { UserIcon, LogoutIcon } from "@heroicons/vue/outline";

const show = ref(false);
const root = ref<HTMLImageElement>();

const toggle = () => {
  show.value = !show.value;
};

/**
 * クリックした要素がrefを設定したdiv要素の内側にあるかどうかチェックする
 * 画像以外クリックでもドロップダウンメニューを閉じるようにする
 * @param e イベント
 */
const clickOutside = (e: Event) => {
  if (!root.value?.contains(e.target) && show.value) {
    show.value = false;
  }
};

onMounted(() => document.addEventListener("click", clickOutside));
onUnmounted(() => document.removeEventListener("click", clickOutside));
</script>

<template>
  <!-- ref: 要素に対して直接アクセスできる -->
  <div ref="root" class="relative">
    <img
      src="@/assets/sakura-ayane.jpeg"
      class="rounded-full w-10 h-10 cursor-pointer"
      @click="toggle"
    />
    <transition
      enter-active-class="transition-opacity duration-300"
      enter-from-class="opacity-0"
      leave-active-class="transition-opacity duration-300"
      leave-to-class="opacity-0"
    >
      <div
        v-show="show"
        class="absolute top-16 right-0 z-10 w-40 py-2 bg-white rounded-sm shadow dark:bg-gray-800"
      >
        <ul>
          <li
            class="text-gray-700 dark:text-gray-300 hover:bg-blue-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-600 p-2"
          >
            <!-- <router-link to="/profile" class="flex items-center space-x-2"> -->
            <UserIcon class="w-5 h-5" />
            <span class="text-sm font-bold">プロファイル</span>
            <!-- </router-link> -->
          </li>
          <li
            class="text-gray-700 dark:text-gray-300 hover:bg-blue-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-600 p-2"
          >
            <a href="/#" class="flex items-center space-x-2">
              <LogoutIcon class="w-5 h-5" />
              <span class="text-sm font-bold">ログアウト</span></a
            >
          </li>
        </ul>
      </div>
    </transition>
  </div>
</template>
