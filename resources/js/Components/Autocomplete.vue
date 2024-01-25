<template>
  <div class="w-full relative text-lg">
    <input
      v-model="search"
      @input="handleInput"
      @blur="handleBlur"
      @focus="handleFocus"
      :placeholder="placeHolder"
      class="bg-gray-700 rounded-lg w-full"
    />
    <div
      v-if="autocompleteResults.length > 0"
      class="bg-gray-600 flex flex-col space-y-1 p-2 rounded absolute top-11 overflow-y-scroll max-h-96 w-1/2 overflow-x-hidden"
    >
      <ul>
        <li
          v-for="result in autocompleteResults"
          :key="result.id"
          @click="handleSelect(result)"
          class="hover:bg-gray-500 transition-colors duration-200 cursor-pointer"
        >
          {{ result.name }} - {{ result.typeSearch }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, onBeforeUnmount } from "vue";
import debounce from "lodash.debounce";
import { useResultsStore } from "@/stores";
import { prepareDestinationsResults, preparePerformersResults, prepareVenuesResults } from "./prepareDestinationsResults";
import { computed } from "vue";

let abortController: AbortController;
let isInputClicked = false;
const prevSearch = ref<string>("");

const search = ref<string>("");
const debounceSearch = ref<string>("");
const autocompleteResults = ref<any[]>([]);
const loading = ref<boolean>(false);
const resultsStore = useResultsStore();
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

const placeHolder = computed(() => (`Type to search ${resultsStore.tab === "event" ? "an Event" : "a Hotel"}`));

const fetchData = async (query: string) => {
  try {
    if (query.length === 0 || !isInputClicked || query === prevSearch.value) {
      return [];
    }

    if (abortController) {
      abortController.abort();
    }

    abortController = new AbortController();

    loading.value = true;

    const response = await fetch(`${route("getAutocompleteOptions")}`, {
      method: "POST",
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken ?? "",
      },
      body: JSON.stringify({ q: query }),
      signal: abortController.signal
    });

    const data = await response.json();

    if (data.error) {
      loading.value = false;
      return [];
    }

    const results = data?.data?.results;

    if (resultsStore.tab === "hotel") {
      return prepareDestinationsResults(results?.destinations);
    } else {
      return [
        ...prepareDestinationsResults(results?.destinations),
        ...preparePerformersResults(results?.performers),
        ...prepareVenuesResults(results?.venues),
      ];
    }
  } catch (error: any) {
    if (error.name === 'AbortError') {
      return [];
    }

    console.error(error);
    return [];
  } finally {
    loading.value = false;
  }
};

const debouncedFetchData = debounce(async (query: string) => {
  autocompleteResults.value = await fetchData(query);
  prevSearch.value = query;
}, 1000);

watch(debounceSearch, () => {
  debouncedFetchData(debounceSearch.value);
});

onBeforeUnmount(() => {
  if (abortController) {
    abortController.abort();
  }
});

const handleSelect = async (item: any) => {
  console.log('Selected:', item);

  autocompleteResults.value = [];
  search.value = item.name;
  // Perform any additional actions when an item is selected

  let routeToCall;
  let body = {};

  if (resultsStore.tab === "event") {
    routeToCall = route("getEvents");
    body = {
      typeSearch: item.typeSearch,
    };

    switch (item.typeSearch) {
      case "destination":
        body = {
          ...body,
          destination: {
            latitude: item.lat.toString(),
            longitude: item.lng.toString(),
            radius: item.radius,
            city: item.name
          }
        };
        break;
      case "performer":
        body = {
          ...body,
          performerId: item.id
        };
        break;
      case "venue":
        body = {
          ...body,
          venueId: item.id,
        };
        break;
    }
  } else {
    routeToCall = route("getHotels");
    body = {
      typeSearch: "destination",
      destination: {
        latitude: item.lat.toString(),
        longitude: item.lng.toString(),
        radius: item.radius,
        city: item.name
      }
    };
  }

  const apiCall = await fetch(routeToCall, {
    method: "POST",
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken ?? "",
    },
    body: JSON.stringify(body),
  });
  const apiCallBody: any = await apiCall.json();

  if (apiCallBody.success === true) {
    const data = apiCallBody?.data?.results;
    if (resultsStore.tab === "event") {
      resultsStore.setResults(data.map((event: any) => ({
        id: event.event_id,
        name: event.event_name,
        date: event.event_date,
        time: event.event_time,
        dateText: event.event_datetext,
        venueName: event.venue_name,
        primaryCategory: event.primary_category,
        categories: event.categories,
        prices: {
          currency: event.prices.currency,
          lowPrice: event.prices.lowPrice,
          averagePrice: event.prices.averagePrice,
          highPrice: event.prices.highPrice,
        },
      })));
    } else {
      resultsStore.setResults(data.map((hotel: any) => ({
        id: hotel.hotel_id,
        name: hotel.hotel_name,
        stars: hotel.hotel_stars,
        type: hotel.hotel_type,
        image: hotel.image,
        nights: hotel.nights,
        location: {
          city: hotel.location.city_name,
          state: hotel.location.state_name,
          country: hotel.location.country_name,
          zone: hotel.location.zone_name,
          address: hotel.location.address,
        },
        prices: {
          currency: hotel.prices.currency,
          lowPrice: hotel.prices.lowPrice,
          averagePrice: hotel.prices.averagePrice,
          highPrice: hotel.prices.highPrice,
        },
      })));
    }
  }
};

const handleInput = (event: Event) => {
  if (isInputClicked) {
    const inputElement = event.target as HTMLInputElement;
    debounceSearch.value = inputElement.value;
  }
};

const handleFocus = () => {
  isInputClicked = true;
};

const handleBlur = () => {
  isInputClicked = false;
};
</script>
