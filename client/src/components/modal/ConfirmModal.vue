<script setup lang="ts">
interface Props {
  is_display: boolean;
  message: string;
}

const props = withDefaults(defineProps<Props>(), {
  is_display: false,
  message: "",
});

const emit = defineEmits<{
  (event: "hideModal", is_result: boolean): void;
}>();
</script>

<template>
  <teleport to="#teleport-target">
    <!-- 以下要素がid="teleport-target"内に描画される -->
    <div
      v-if="props.is_display"
      id="popup-modal"
      tabindex="-1"
      class="fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-black bg-opacity-30 z-20"
    >
      <div class="relative p-4 w-full max-w-md h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <!-- Modal header -->
          <div class="flex justify-end p-2">
            <button
              @click="emit('hideModal', false)"
              type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
              data-modal-toggle="popup-modal"
            >
              <svg
                class="w-5 h-5"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-6 pt-0 text-center">
            <svg
              class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
              ></path>
            </svg>
            <h3
              class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"
            >
              {{ props.message }}
            </h3>
            <button
              @click="emit('hideModal', true)"
              data-modal-toggle="popup-modal"
              type="button"
              class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white mr-3"
            >
              OK
            </button>
            <button
              @click="emit('hideModal', false)"
              data-modal-toggle="popup-modal"
              type="button"
              class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-white"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </teleport>
</template>
