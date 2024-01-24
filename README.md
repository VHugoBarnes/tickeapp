<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# TickeApp
This document will show you my journey and mental process to complete Ticketero task.

## Task sentence
Make calls to Ticketero API to search by venue, destination, and by performer using the autocomplete service to get the required data.

## Required information
- [x] Documentation Link (remains private).   
- [x] Base endpoint (this one is public because you can see it on the network tab).   
- [x] Auth token (remains private).   

## How I'm going to solve it

### First contact
- I'm going to use Laravel because it brings an easier startpoint than vanilla PHP and I'm more familiar with it than with CodeIgniter.   
- So, what is needed is a cute and useful frontend with a search bar, and a list of cards to display the results, divided by Venue, Destination, and Performer.   
- I'm gonna start by calling the endpoints with Postman to get familiar with different scenarios.   
  - I received small amount of data, I was wondering why, but then I realized that this information needs to be displayed as an autocomplete from the search bar, not an autocomplete as a tool where you can write up "Dal" and information about "Dallas" will come up (which is also the case).   
- I'm not going to use Laravel as MVC, but rather as a RESTful Web Server.   
- I'm going to create a SPA with Vue to handle dynamism (I'm going to do it with Inertia).   
- I'm going to configure Inertia with Vue, install Guzzle and start with a simple call to autocomplete endpoint, after that I'm going to create a Figma mockup to design my solution.   
- I had success with making the request, and before I go to Figma is obvious that I need several components like a Search, and Card components.   
- The Search component is going to be calling every certain seconds (1 second probably) and call the autocomplete route to display the results so the user can click on a result, therefore, calling the Event, or Hotel.
  - **Important:** If the user has `Event` selected, show autocomplete of `Destination`, `Venue`, and `Performer`, but if `Hotel` is selected only show `Destination` because that's the only param we can search for.   


### Solving the Task
#### Frontend
1. We are going to need only one page, so no router is needed.   
2. We need to manage state globally, I'm going to use Pinia.   
  a. The store will be something like this:
  ```typescript title="resources/js/store/index.ts"
  import {defineStore} from "pinia";

  export const useCounterStore = defineStore("results", {
    state: () => ({
      loading: boolean, // "false" as default
      tab: Tab, //Enum: "event" | "hotel",  "event" as default
      autocompleteResults: AutoCompleteResults[], // Interface TBD
      results: Event[] | Hotel [], // Interfaces TBD
    }),
    actions: {
      setLoading(value: boolean) {
        this.loading = value;
      },
      setTab(tab: Tab) {
        this.tab = tab;
      },
      setAutoCompleteResults(options: AutoCompleteResults[]) { // this works as a reset too...
        this.autocompleteResults = options;
      },
      setResults(results: Event[] | Hotel[]) {
        this.results = results;
      }
    }
  });
  ```
3. A Tab component to select either `Event` or `Hotel`.   
4. A Search component.   
  a. When the user starts typing we are going to wait 1 second to send the call to the autocomplete endpoint/route. We have to be very careful and terminate the previous fetch call to avoid network leaks.   
  b. When the fetch call starts we are going to display the loading circle and then display the results in a dropdown-like way.   
  c. We need to check what type the user is in to only display certain autocomplete results, for example, if the tab is `Hotel`, we are only going to display autocomplete results of `destinations`, and if it's `Event`, all.   
  d. Once the user selects a result from autocomplete, we call the endpoint/route to get the results and close the dropdown, and clean the `autocompleteResults`, the selected result will be kept in the search input.   
5. A Card component to display the results.   
  a. So we are going to create an `Event` and `Hotel` card, and decide what type of Card to display.   

### Backend
1. Create a class to easily call the base endpoint and get the JSON result.   
2. Create a route to get autocomplete results.   
  a. We are going to get as query params a `q` to represent the query, and we are going to have a fixed limit so is not needed.   
3. Create a route to get events.   
  a. If the selected autocomplete option is a `destination`: This one is going to be a POST route, we are going to pass `destination` object with `latitude`, `longitude`, `radius`, and `city` as values of it. Start and end date will be fixed from current date to one week, so no need to pass them.   
  b. If the selected autocomplete option is a `performer`: This one is going to be a POST route, and we are going to pass a `performerId`.   
  c. If the selected autocomplete option is a `venue`: This one is going to be a POST route, and we are going to pass a `venueId`.   
4. Create a route to get hotels.   
  a. This one is going to be a POST route, we are going to pass `destination` object with `latitude`, `longitude`, `radius`, and `city` as values of it. Start and end date will be fixed from current date to one week, so no need to pass them.   


## What's next
- Add a Rate Limiter would be a good idea.   
- A router to save the search query so we can reload or share the link.   
