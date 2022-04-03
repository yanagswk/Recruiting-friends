<script setup lang="ts">
import { reactive, computed } from "vue";
import { useRoute } from "vue-router";
import {
  TemplateIcon,
  ShoppingCartIcon,
  ChevronDownIcon,
} from "@heroicons/vue/outline";

const lists = reactive([
  {
    name: "ダッシュボード",
    icon: "TemplateIcon",
    link: "/",
  },
  {
    name: "EC",
    icon: "ShoppingCartIcon",
    link: "/#",
    show: false,
    sublists: [
      {
        name: "商品一覧",
        link: "/product",
      },
      {
        name: "注文一覧",
        link: "/order",
      },
      {
        name: "カテゴリー一覧",
        link: "/#",
      },
    ],
  },
  {
    name: "ダッシュボード",
    icon: "TemplateIcon",
    link: "/",
  },
]);

// script setupではdynamic componentsを利用するためには、オブジェクトを事前に設定しておく必要がある
const icons = {
  TemplateIcon: TemplateIcon,
  ShoppingCartIcon: ShoppingCartIcon,
};

const toggle = (name: string) => {
  const list = lists.find((list) => list.name === name);
  if (list) list.show = !list.show;
};

const enter = (element: HTMLElement) => {
  console.log(element);
  console.log(typeof element);
  element.style.height = "auto";
  const height = getComputedStyle(element).height;
  element.style.height = "0";
  getComputedStyle(element);
  setTimeout(() => {
    element.style.height = height;
  });
};

const leave = (element: HTMLElement) => {
  element.style.height = getComputedStyle(element).height;
  getComputedStyle(element);
  setTimeout(() => {
    element.style.height = "0";
  });
};

/**
 * パス情報取得
 */
const currentRoute = computed(() => {
  return useRoute().fullPath;
});
</script>

<template>
  <ul class="text-gray-700 dark:text-gray-300">
    <li v-for="list in lists" :key="list.name" class="mb-1">
      <router-link
        v-if="!list.sublists"
        :to="list.link"
        class="flex items-center p-2 rounded-sm hover:text-white hover:bg-blue-400"
        :class="{ 'bg-blue-600 text-white': currentRoute === list.link }"
      >
        <component :is="icons[list.icon]" class="w-6 h-6 mr-2"></component>
        <span>{{ list.name }}</span>
      </router-link>
      <div
        v-else
        class="flex items-center justify-between p-2 cursor-pointer rounded-sm hover:bg-blue-400 hover:text-white"
        @click="toggle(list.name)"
      >
        <div class="flex items-center">
          <component :is="icons[list.icon]" class="w-6 h-6 mr-2"></component>
          <span>{{ list.name }}</span>
        </div>
        <ChevronDownIcon
          class="w-4 h-4"
          :class="!list.show ? 'rotate-0' : '-rotate-180'"
        />
      </div>
      <transition @enter="enter" @leave="leave">
        <ul v-show="list.show" class="mt-1 overflow-hidden">
          <li v-for="sublist in list.sublists" :key="sublist.name" class="mb-1">
            <router-link
              :to="sublist.link"
              class="block p-2 rounded-sm hover:bg-blue-400 hover:text-white"
              :class="{
                'bg-blue-600 text-white': currentRoute === sublist.link,
              }"
            >
              <span class="pl-8">{{ sublist.name }}</span>
            </router-link>
          </li>
        </ul>
      </transition>
    </li>
  </ul>
</template>

<style scoped>
/* .v-enter-from,
.v-leave-to {
  height: 0;
} */
.v-enter-active,
.v-leave-active {
  transition: height 0.3s;
}
/* .v-enter-to,
.v-leave-from {
  height: 100px;
} */
</style>
