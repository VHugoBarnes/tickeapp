<template>
  <div
    class="bg-gray-700 hover:bg-gray-900 hover:scale-105 transition-all duration-200 cursor-pointer rounded-lg p-4 space-y-6"
  >
    <div class="flex items-start space-x-2">
      <div class="">
        <div class="bg-blue-500 rounded-t-lg py-1 px-2">{{ dayjs(result.date).format("MMMM") }}</div>
        <div class="bg-gray-200 text-gray-900 rounded-b-lg flex items-center justify-center py-1 px-2">{{
          dayjs(result.date).format("DD") }}</div>
      </div>
      <div>
        <h2 class="text-2xl font-bold tracking-tight">
          {{ result.name }}
        </h2>
      </div>
    </div>
    <div class="space-y-2 text-gray-300">
      <div class="flex space-x-2 items-center">
        <MapPinIcon class="w-6 h-6 " />
        <p>{{ result.venueName }}</p>
      </div>

      <div class="flex space-x-2 items-center">
        <CurrencyDollarIcon class="w-6 h-6 " />
        <div class="flex space-x-1 items-center">
          <ArrowDownIcon class="w-4 h-4" />
          <p>${{ result.prices.lowPrice }}</p>
        </div>
        <div
          v-if="result.prices.highPrice"
          class="flex space-x-1 items-center"
        >
          <ArrowUpIcon class="w-4 h-4" />
          <p>${{ result.prices.highPrice }}</p>
        </div>
      </div>

      <div class="flex space-x-2 items-center">
        <ClockIcon class="w-6 h-6 " />
        <p>{{ result.time }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import dayjs from "dayjs";
import { Event } from '@/types';
import { MapPinIcon, CurrencyDollarIcon, ArrowDownIcon, ArrowUpIcon, ClockIcon } from "@heroicons/vue/16/solid";


defineProps<{ result: Event }>();
</script>
