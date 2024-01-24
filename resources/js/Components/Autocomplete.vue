<template>
  <v-autocomplete
    v-model="search"
    :items="autocompleteResults"
    :loading="loading"
    :search-input.sync="debounceSearch"
    @input="handleInput"
    item-text="name"
    label="Search"
  ></v-autocomplete>
</template>

<script setup lang="ts">
import { ref, watch, onMounted, onBeforeUnmount } from "vue";
import debounce from "lodash.debounce";

import { useResultsStore } from "@/stores";
import { AutoCompleteResultT, TypeSearch, Destination, Performer, Venue } from "@/types";

const resultsStore = useResultsStore();

const search = ref<string>("");
const debounceSearch = ref<string>("");
const autocompleteResults = ref<AutoCompleteResultT>([]);
const loading = ref<boolean>(false);
let abortController: AbortController;

const fetchData = async () => {
  try {
    // Abort the previous request
    if (abortController) {
      abortController.abort();
    }

    // Create a new AbortController for the current request
    abortController = new AbortController();

    loading.value = true;

    const response = await fetch(route("getAutocompleteOptions"), {
      method: "GET",
      body: JSON.stringify({ q: debounceSearch.value }),
      signal: abortController.signal
    });
    const data = await response.json();

    if (data.error) {
      loading.value = false;
      return;
    }

    const results = data?.data?.results;

    if (resultsStore.tab === "hotel") {
      autocompleteResults.value = prepareDestinationsResults(results?.destinations);
    } else {
      autocompleteResults.value = [
        ...prepareDestinationsResults(results?.destinations),
        ...preparePerformersResults(results?.performers),
        ...prepareVenuesResults(results?.venues),
      ]
    }
  } catch (error: any) {
    if (error.name === 'AbortError') {
      // Ignore aborted requests
      return;
    }

    console.error(error);
  } finally {
    loading.value = false;
  }
};

const prepareDestinationsResults = (destinations: any[]): Destination[] => {
  return destinations?.map((d: any) => ({
    id: d.id,
    name: d.name,
    code: d.code,
    country: d.country,
    state: d.state,
    lat: d.lat,
    lng: d.lng,
    radius: d.radius,
    airport: d.airport,
    typeSearch: TypeSearch.destination
  }));
};

const preparePerformersResults = (performers: any[]): Performer[] => {
  return performers.map((p: any) => ({
    id: p.id,
    name: p.name,
    typeSearch: TypeSearch.performer
  }));
};

const prepareVenuesResults = (venues: any[]): Venue[] => {
  return venues.map((v: any) => ({
    id: v.id,
    name: v.name,
    typeSearch: TypeSearch.venue
  }));
};

const debouncedFetchData = debounce(() => {
  fetchData();
}, 1000);

watch(debounceSearch, () => { debouncedFetchData(); });

onBeforeUnmount(() => {
  // Cleanup on component unmount
  if (abortController) {
    abortController.abort();
  }
});

const handleInput = () => {
  debounceSearch.value = search.value;
};
</script>
