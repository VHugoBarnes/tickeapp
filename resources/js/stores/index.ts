import { defineStore } from "pinia";

export enum Tab {
  event = "event",
  hotel = "hotel"
}

export interface AutoCompleteResults { }
export interface Event { }
export interface Hotel { }

interface State {
  loading: boolean;
  tab: Tab;
  autocompleteResults: AutoCompleteResults[],
  results: Event[] | Hotel[]
}

export const useCounterStore = defineStore("results", {
  state: (): State => ({
    loading: false,
    tab: Tab.event,
    autocompleteResults: [],
    results: [],

  }),
  actions: {
    setLoading(value: boolean) {
      this.loading = value;
    },
    setTab(tab: Tab) {
      this.tab = tab;
    },
    setAutoCompleteResults(options: AutoCompleteResults[]) {
      this.autocompleteResults = options;
    },
    setResults(results: Event[] | Hotel[]) {
      this.results = results;
    }
  }
});
