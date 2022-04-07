<script setup lang="ts"></script>

<template>
  <div class="flex items-center justify-center">
    <form method="GET">
      <div class="relative text-gray-600">
        <span class="absolute inset-y-0 left-0 flex items-center pl-2">
          <button type="submit" class="p-1 outline-none shadow-outline">
            <svg
              fill="none"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              viewBox="0 0 24 24"
              class="w-6 h-6"
            >
              <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
          </button>
        </span>
        <input
          type="search"
          name="q"
          class="py-2 text-sm bg-gray-300 rounded-md pl-10 outline-none"
          placeholder="募集したいゲーム名"
          autocomplete="off"
        />
      </div>
    </form>
  </div>
</template>
