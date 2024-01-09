<template>
  <v-alert
      closable
      v-model="alert.active"
      :title="alert.title"
      :text="alert.message"
      :type="alert.type"
      variant="outlined"
  />
  <router-view></router-view>
</template>

<script setup lang="ts">
  import { useAppStore } from "./stores/appStore.ts";
  import {computed} from "vue";

  const appStore = useAppStore()

  const alert = computed(() => appStore.getAlert )
</script>

<style scoped>

</style>
