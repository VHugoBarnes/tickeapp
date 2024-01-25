<template>
  <div class="space-y-8">
    <h2 class="text-2xl font-bold tracking-wide leading-relaxed">
      Results
    </h2>

    <div
      class="flex items-center justify-center"
      v-if="resultStore.loading === true"
    >
      <p class="text-xl font-bold tracking-wide leading-relaxed animate-pulse">Loading...</p>
    </div>

    <div
      v-if="resultStore.tab === 'event'"
      class="space-y-4"
    >
      <EventResult
        v-for="event in resultStore.results"
        :key="event.id"
        :result="event"
      />
    </div>

    <div
      v-if="resultStore.tab === 'hotel'"
      class="space-y-4"
    >
      <HotelResult
        v-for="hotel in resultStore.results"
        :key="hotel.id"
        :result="hotel"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import EventResult from "./EventResult.vue";
import HotelResult from "./HotelResult.vue";
import { useResultsStore } from "@/stores";

const resultStore = useResultsStore(); // We will take resultStore.results
</script>
