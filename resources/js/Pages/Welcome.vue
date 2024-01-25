<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import Tabs from "@/Components/Tabs.vue";
import Autocomplete from "@/Components/Autocomplete.vue";
import ResultsGrid from "@/Components/ResultsGrid.vue";

defineProps<{
  laravelVersion: string;
  phpVersion: string;
}>();
</script>

<template>
  <Head title="Welcome" />

  <div
    class="relative text-gray-300 sm:flex sm:justify-center sm:items-center min-h-screen bg-center bg-gray-950 selection:bg-red-500 selection:text-white"
  >
    <div class="w-full lg:w-1/2 lg:max-w-7xl mx-auto p-6 lg:p-8 space-y-10">
      <header class="flex flex-col justify-center items-center">
        <svg
          width="91"
          height="91"
          viewBox="0 0 91 91"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
          class="h-16 w-autobg-gray-950"
        >
          <g clip-path="url(#clip0_1209_2)">
            <path
              d="M65.385 42.6425L63.9636 44.0639M58.278 49.7496L56.8565 51.171M51.1709 56.8566L49.7495 58.278M44.0638 63.9637L42.6424 65.3851M35.5353 38.3782L45.4852 48.3281M31.2711 42.6425L36.9567 48.3281M41.9317 16.3463C40.7548 15.1694 38.8444 15.1694 37.6674 16.3463L31.9325 22.0812C32.2997 23.4453 32.301 24.882 31.9362 26.2467C31.5714 27.6114 30.8535 28.8558 29.8546 29.8547C28.8557 30.8535 27.6113 31.5715 26.2466 31.9363C24.8819 32.3011 23.4452 32.2998 22.0811 31.9326L16.3462 37.6675C15.1693 38.8445 15.1693 40.7548 16.3462 41.9318L49.0388 74.6243C50.2157 75.8013 52.1261 75.8013 53.303 74.6243L59.0379 68.8894C58.6707 67.5254 58.6694 66.0886 59.0342 64.7239C59.399 63.3593 60.117 62.1148 61.1159 61.1159C62.1147 60.1171 63.3592 59.3991 64.7239 59.0343C66.0885 58.6695 67.5253 58.6708 68.8893 59.038L74.6242 53.3031C75.8012 52.1262 75.8012 50.2158 74.6242 49.0388L41.9317 16.3463Z"
              stroke="#BE123C"
              stroke-width="5"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </g>
          <defs>
            <clipPath id="clip0_1209_2">
              <rect
                width="64.3259"
                height="64.3259"
                fill="white"
                transform="translate(45.4852) rotate(45)"
              />
            </clipPath>
          </defs>
        </svg>

        <h1 class="text-center font-black text-5xl tracking-tight leading-relaxed">
          <span>Ticke.</span><span class="text-rose-700 text-4xl">App</span>
        </h1>
      </header>

      <main class="space-y-8">
        <div class="space-y-2">
          <Tabs />
          <Autocomplete />
        </div>
        <ResultsGrid />
      </main>

      <footer class="grid grid-cols-2 lg:grid-cols-3 gap-8 mt-16 px-6">
        <div class="text-center text-sm text-gray-400 sm:text-start">
          <div class="flex items-center gap-4">
            Laravel v{{ laravelVersion }}
          </div>
        </div>

        <div class="ms-4 text-center text-sm  text-gray-400 sm:text-end sm:ms-0">
          (PHP v{{ phpVersion }})
        </div>

        <div class="ms-4 text-center text-sm underline text-gray-400 sm:text-end sm:ms-0 col-span-2 lg:col-span-1">
          <a href="https://victorvazquez.dev">victorvazquez.dev</a>
        </div>
      </footer>
    </div>
  </div>
</template>

<style>
.bg-dots-darker {
  background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
  .dark\:bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
  }
}
</style>
