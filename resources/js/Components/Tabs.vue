<template>
  <div class="flex items-center space-x-2 text-lg">
    <button
      class="text-gray-300 bg-gray-700 hover:bg-gray-900 py-2 px-4 rounded-lg"
      :class="{ 'bg-gray-900 border-solid border-t-2 border-rose-700 text-rose-700': resultsStore.tab === Tab.event }"
      @click="resultsStore.setTab(Tab.event)"
    >
      Event
    </button>
    <button
      class="text-gray-300 bg-gray-700 hover:bg-gray-900 py-2 px-4 rounded-lg"
      :class="{ 'bg-gray-900 border-solid border-t-2 border-rose-700 text-rose-700': resultsStore.tab === Tab.hotel }"
      @click="resultsStore.setTab(Tab.hotel)"
    >
      Hotel
    </button>
  </div>
</template>

<script setup lang="ts">
import { useResultsStore } from "@/stores";
import { Tab } from "@/types";

const resultsStore = useResultsStore();
</script>
