<script setup lang="ts">
import { ref, onMounted, onUnmounted } from "vue";
import { MenuIcon, MoonIcon, SunIcon } from "@heroicons/vue/outline";
// import { debounce } from 'lodash';

// モードtype
type Mode = "dark" | "light";

const innerWidth = ref(window.innerWidth); // 画面横幅取得
const show = ref(innerWidth.value >= 1280 ? true : false); // サイドバー表示するか
const theme = ref<Mode>("light");

const checkWindowSize = () => {
  if (window.innerWidth >= 1280) {
    if (show.value === false && innerWidth.value < 1280) show.value = true;
  } else {
    if (show.value === true) show.value = false;
  }
  innerWidth.value = window.innerWidth;
};

if (localStorage.theme === "dark") {
  document.documentElement.classList.add("dark");
  theme.value = "dark";
} else {
  document.documentElement.classList.remove("dark");
  theme.value = "light";
}

const changeMode = (mode: Mode) => {
  theme.value = mode;
  theme.value === "light"
    ? document.documentElement.classList.remove("dark")
    : document.documentElement.classList.add("dark");
  localStorage.theme = mode;
};

onMounted(() => {
  // リサイズ時にサイドバー表示非表示イベント
  window.addEventListener("resize", checkWindowSize);
});
onUnmounted(() => {
  window.removeEventListener("resize", checkWindowSize);
});
</script>

<template>
  <div class="relative">
    <div
      class="fixed top-0 w-64 h-screen bg-white dark:bg-gray-800 z-20 transform duration-300 dark:text-gray-300"
      :class="{ '-translate-x-full': !show }"
    >
      サイドバー
    </div>
    <!-- 画面幅が狭い場合 -->
    <div
      v-show="show"
      class="fixed xl:hidden inset-0 bg-gray-900 opacity-50 z-10"
      @click="show = !show"
    ></div>
    <div
      class="bg-gray-100 dark:bg-gray-900 h-screen overflow-hidden duration-300"
      :class="{ 'xl:pl-64': show }"
    >
      <div
        class="flex items-center justify-between bg-white dark:bg-gray-800 rounded shadow m-4 p-4"
      >
        <MenuIcon
          class="h-6 w-6 text-gray-600 dark:text-gray-300 cursor-pointer"
          @click="show = !show"
        />
        <MoonIcon
          v-if="theme === 'light'"
          class="w-7 h-7 text-gray-600 cursor-pointer"
          @click="changeMode('dark')"
        />
        <SunIcon
          v-else
          class="w-7 h-7 text-gray-300 cursor-pointer"
          @click="changeMode('light')"
        />
      </div>
      <div class="dark:text-gray-300">
        <slot />
      </div>
    </div>
  </div>
</template>
