<template>
  <div class="bg-gray-700 rounded-lg p-4">
    <h2 class="text-2xl font-bold tracking-wide leading-relaxed">
      Result
    </h2>
    <p>
      {{ JSON.stringify(result) }}
    </p>
  </div>
</template>

<script setup lang="ts">
import { Event, Hotel } from '@/types';


defineProps<{ result: Event | Hotel }>();
</script>
