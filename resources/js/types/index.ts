export enum Tab {
  event = "event",
  hotel = "hotel"
}

export enum TypeSearch {
  performer = "performer",
  venue = "venue",
  destination = "destination"
};

export interface Performer {
  id: number;
  name: string;
  typeSearch: TypeSearch.performer
}
export interface Venue {
  id: number;
  name: string;
  typeSearch: TypeSearch.venue
}
export interface Destination {
  id: number;
  name: string;
  code: string;
  country: string;
  state: string;
  lat: number;
  lng: number;
  radius: number;
  airport: string;
  typeSearch: TypeSearch.destination
}

export interface Price {
  currency: string;
  lowPrice: number;
  averagePrice: number;
  highPrice: number;
};

export interface AutoCompleteResult {
  performers?: Performer[],
  venues?: Venue[],
  destinations: Destination[],
}

export type AutoCompleteResultT = (Performer | Venue | Destination)[];

export interface Event {
  id: number;
  name: string;
  date: string;
  time: string;
  dateText: string;
  venueName: string;
  primaryCategory: string;
  categories: string[];
  prices: Price;
}
export interface Hotel {
  id: number;
  name: string;
  stars: string;
  type: string;
  image: string;
  nights: number;
  location: {
    city: string;
    state: string;
    country: string;
    zone: string;
    address: string;
  },
  prices: Price;
}
