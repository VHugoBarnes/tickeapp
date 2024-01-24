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
- I'm going to use Laravel because it brings an easier startpoint than vanilla PHP and I'm more familiar with it than with CodeIgniter.   
- So, what is needed is a cute and useful frontend with a search bar, and a list of cards to display the results, divided by Venue, Destination, and Performer.   
- I'm gonna start by calling the endpoints with Postman to get familiar with different scenarios.   
  - I received small amount of data, I was wondering why, but then I realized that this information needs to be displayed as an autocomplete from the search bar, not an autocomplete as a tool where you can write up "Dal" and information about "Dallas" will come up (which is also the case).   
- I'm not going to use Laravel as MVC, but rather as a RESTful Web Server.   
- I'm going to create a SPA with Vue to handle dynamism (I'm going to do it with Inertia).   
- I'm going to configure Inertia with Vue, install Guzzle and start with a simple call to autocomplete endpoint, after that I'm going to create a Figma mockup to design my solution.   
