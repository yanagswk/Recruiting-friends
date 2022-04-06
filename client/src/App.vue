<script setup lang="ts">
import { ref } from "vue";
import DefaultBar from "./layouts/DefaultBar.vue";

const test = "aaa";
</script>

<template>
  <DefaultBar>
    <router-view></router-view>
  </DefaultBar>
</template>
