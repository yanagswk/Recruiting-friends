<script setup lang="ts"></script>

<template>
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8">
    <!-- person - start -->
    <div class="flex flex-col items-center bg-gray-100 rounded-lg p-4 lg:p-8">
      <div
        class="w-24 md:w-32 h-24 md:h-32 bg-gray-200 rounded-full overflow-hidden shadow-lg mb-2 md:mb-4"
      >
        <img
          src="https://images.unsplash.com/photo-1567515004624-219c11d31f2e??auto=format&q=75&fit=crop&w=256"
          loading="lazy"
          alt="Photo by Radu Florin"
          class="w-full h-full object-cover object-center"
        />
      </div>

      <div>
        <div class="text-indigo-500 md:text-lg font-bold text-center">
          Apex Legends
        </div>
        <p class="text-gray-500 text-sm md:text-base text-center mb-3 md:mb-4">
          PS4
        </p>
      </div>
    </div>
  </div>
</template>
