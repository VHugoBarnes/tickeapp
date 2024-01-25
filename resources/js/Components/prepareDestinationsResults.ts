import { TypeSearch } from "@/types";

export const prepareDestinationsResults = (destinations: any[]): any[] => {
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
export const preparePerformersResults = (performers: any[]): any[] => {
  return performers.map((p: any) => ({
    id: p.id,
    name: p.name,
    typeSearch: TypeSearch.performer
  }));
};
export const prepareVenuesResults = (venues: any[]): any[] => {
  return venues.map((v: any) => ({
    id: v.id,
    name: v.name,
    typeSearch: TypeSearch.venue
  }));
};
