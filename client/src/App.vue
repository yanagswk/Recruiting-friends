<!-- <script setup lang="ts">
import DefaultBar from "./layouts/DefaultBar.vue";
</script>

<template>
  <DefaultBar>ダッシュボード</DefaultBar>
</template> -->
<script setup lang="ts">
import DefaultBar from "./layouts/DefaultBar.vue";
</script>

<template>
  <DefaultBar>
    <router-view></router-view>
  </DefaultBar>
</template>
