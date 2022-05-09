<script setup lang="ts">
import { ref, watchEffect, computed } from "vue";
import { useStore } from "@/store/index";
import * as MutationTypes from "@/store/mutationType";

const store = useStore();

const currentPageEdited = ref(1);
// const currentPageEdited = store.state.currentPageEdited;

const props = defineProps<{
  showPages: number; //ページネーションを何件表示するか
  currentPage: number; //現在のページ
  totalCount: number; //総件数
  totalPages: number; //総ページ数
  // perPage: number; //1ページあたりの表示件数 (api側で設定)
}>();

const emit = defineEmits<{
  (eventName: "currentPage", page: number): void;
}>();

/**
 * 総記事数が表示ページ数以下の場合に調整する
 */
const showPagesFix = computed(() => {
  if (props.totalPages < props.showPages) {
    return props.totalPages;
  } else {
    return props.showPages;
  }
});

/**
 * ページ番号を計算する
 */
const numFix = computed(() => {
  return function (num: any) {
    let ajust = 1 + (props.showPages - 1) / 2;
    let result = num;
    //前ページがマイナスになる場合は1からはじめる
    if (currentPageEdited.value > props.showPages / 2) {
      result = num + currentPageEdited.value - ajust;
    }
    //後ページが最大ページを超える場合は最大ページを超えないようにする
    if (currentPageEdited.value + props.showPages / 2 > props.totalPages) {
      result = props.totalPages - props.showPages + num;
    } //総ページ数が表示ページ数に満たない場合、連番そのまま
    if (props.totalPages <= props.showPages) {
      result = num;
    }
    return result;
  };
});

/**
 * 現在のページ数をセット
 * emit送信
 */
const setPage = (page: number) => {
  // マイナスにならないように
  if (page <= 0) {
    currentPageEdited.value = 1;
  }
  // 最大ページ数を超えないように
  else if (page > props.totalPages) {
    currentPageEdited.value = props.totalPages;
  } else {
    currentPageEdited.value = page;
  }
  emit("currentPage", currentPageEdited.value);
};

watchEffect(() => {
  //ページネーションを複数設置したときの対応
  // currentPage(val) {
  //   var vm = this;
  //   vm.$set(vm, "currentPageEdited", vm.currentPage);
  // },
});
</script>

<template>
  <div class="flex mt-10" v-if="totalPages">
    <!-- 一番初めに戻る -->
    <a
      href="#"
      class="flex items-center justify-center px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-gray-200 rounded-md hover:bg-blue-500 hover:text-white"
      :class="{ disabled: currentPageEdited == 1 }"
      @click.prevent="setPage(1)"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-4 w-4"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z"
          clip-rule="evenodd"
        />
      </svg>
    </a>
    <!-- 前に戻る -->
    <a
      href="#"
      class="flex items-center justify-center px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-gray-200 rounded-md hover:bg-blue-500 hover:text-white"
      :class="{ disabled: currentPageEdited == 1 }"
      @click.prevent="setPage(currentPageEdited - 1)"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-4 w-4"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
          clip-rule="evenodd"
        />
      </svg>
    </a>
    <!-- ここからページ数分のリンクを生成 -->
    <template v-for="num in showPagesFix" :key="num">
      <template v-if="numFix(num) == currentPageEdited">
        <span
          class="hidden px-4 py-2 mx-1 text-white transition-colors duration-200 transform bg-blue-500 rounded-md sm:inline dark:bg-gray-900 dark:text-gray-200 hover:bg-blue-500 hover:text-white"
          :class="{ active: numFix(num) == currentPageEdited }"
          >{{ numFix(num) }}</span
        >
      </template>
      <a
        v-else
        href="#"
        class="hidden px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-gray-200 rounded-md sm:inline dark:bg-gray-900 dark:text-gray-200 hover:bg-blue-500 dark:hover:bg-blue-500 hover:text-white dark:hover:text-gray-200"
        @click.prevent="setPage(numFix(num))"
        >{{ numFix(num) }}</a
      >
    </template>
    <!-- 1ページ次に進むリンク -->
    <a
      href="#"
      class="flex items-center justify-center px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-gray-200 rounded-md hover:bg-blue-500 hover:text-white"
      :class="{ disabled: currentPageEdited == totalPages }"
      @click.prevent="setPage(currentPageEdited + 1)"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-4 w-4"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
          clip-rule="evenodd"
        />
      </svg>
    </a>
    <!-- 一番最後のページ -->
    <a
      href="#"
      class="flex items-center justify-center px-4 py-2 mx-1 text-gray-700 transition-colors duration-200 transform bg-gray-200 rounded-md hover:bg-blue-500 hover:text-white"
      :class="{ disabled: currentPageEdited == totalPages }"
      @click.prevent="setPage(totalPages)"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-4 w-4"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
          clip-rule="evenodd"
        />
        <path
          fill-rule="evenodd"
          d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
          clip-rule="evenodd"
        />
      </svg>
    </a>
  </div>
</template>
