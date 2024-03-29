import { Tab, AutoCompleteResultT, Event, Hotel } from "@/types";
import { defineStore } from "pinia";

interface State {
  loading: boolean;
  loadingAutocomplete: boolean;
  tab: Tab;
  autocompleteResults: AutoCompleteResultT,
  results: (Event | Hotel)[]
}

export const useResultsStore = defineStore("results", {
  state: (): State => ({
    loading: false,
    loadingAutocomplete: false,
    tab: Tab.event,
    autocompleteResults: [],
    results: [],

  }),
  actions: {
    setLoading(value: boolean) {
      this.loading = value;
    },
    setLoadingAutocomplete(value: boolean) {
      this.loadingAutocomplete = value;
    },
    setTab(tab: Tab) {
      this.tab = tab;
    },
    setAutoCompleteResults(options: AutoCompleteResultT) {
      this.autocompleteResults = options;
    },
    setResults(results: Event[] | Hotel[]) {
      this.results = results;
    }
  }
});
