<template>
  <div
    class="bg-gray-700 hover:bg-gray-900 hover:scale-105 transition-all duration-200 cursor-pointer rounded-lg space-y-2"
  >
    <img
      :src="result.image"
      :alt="result.name"
      class="rounded-t-lg object-cover h-52 w-full"
    />
    <div class="p-4 space-y-4">
      <h2 class="text-2xl font-bold tracking-tight">
        {{ result.name }}
      </h2>

      <div class="space-y-6">
        <div class="space-y-2 text-gray-300">
          <div class="flex space-x-2 items-center">
            <MapPinIcon class="w-6 h-6 " />
            <p>{{ result.location.city }} {{ result.location.address }}, {{ result.location.state }}</p>
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
            <MoonIcon class="w-6 h-6 " />
            <p>Nights: {{ result.nights }} </p>
          </div>
        </div>

        <div class="bg-gray-900 p-2 rounded-lg inline-flex space-x-1 items-center flex-shrink">
          <StarIcon
            v-for="index in parseInt(result.stars) || 0"
            :key="index"
            class="w-5 h-5"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Hotel } from '@/types';
import { MapPinIcon, CurrencyDollarIcon, ArrowDownIcon, ArrowUpIcon, MoonIcon, StarIcon } from "@heroicons/vue/16/solid";


defineProps<{ result: Hotel }>();
</script>
