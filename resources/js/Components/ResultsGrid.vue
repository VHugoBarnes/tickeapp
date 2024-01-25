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
      class="grid grid-cols-1 md:grid-cols-2 gap-6"
    >
      <EventResult
        v-for="event in (resultStore.results)"
        :key="event.id"
        :result="(event as REvent)"
      />
    </div>

    <div
      v-if="resultStore.tab === 'hotel'"
      class="grid grid-cols-1 md:grid-cols-2 gap-6"
    >
      <HotelResult
        v-for="hotel in resultStore.results"
        :key="hotel.id"
        :result="(hotel as RHotel)"
      />
    </div>

    <div
      v-if="resultStore.results.length === 0 && resultStore.loading === false"
      class="flex flex-col justify-center items-center space-y-2"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="#1f2937"
        class="w-12 h-12 rotate-45"
        v-if="resultStore.tab === 'event'"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z"
        />
      </svg>

      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="#1f2937"
        class="w-12 h-12"
        v-if="resultStore.tab === 'hotel'"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z"
        />
      </svg>


      <p class="text-gray-800 font-semibold text-lg">
        No awesome {{ resultStore.tab === "event" ? "Events" : "Hotels" }} in sight
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import EventResult from "./EventResult.vue";
import HotelResult from "./HotelResult.vue";
import { useResultsStore } from "@/stores";
import { Event as REvent, Hotel as RHotel } from "@/types";

const resultStore = useResultsStore(); // We will take resultStore.results
</script>
