<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Http\Request as HttpRequest;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  public function test()
  {
    dd([
      'APP_ENV' => config('app.env'),
      'api_base_url' => config('app.api_base_url'),
      // Add more variables as needed
    ]);
  }

  private function fetchData($path, $method, $body)
  {
    $BASE_URL = config('app.api_base_url');
    $API_KEY = config('app.api_key');

    $httpClient = new Client();

    $headers = [
      "Accept" => "application/json",
      "Content-Type" => "application/json",
      "Authorization" => "Bearer $API_KEY"
    ];

    try {
      $request = new GuzzleRequest($method, "$BASE_URL$path", $headers, $body);
      $res = $httpClient->sendAsync($request)->wait();
      $resBody = $res->getBody()->getContents();

      $data = json_decode($resBody, true);

      return $data;
    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }

  public function getAutocompleteOptions(HttpRequest $httpRequest)
  {
    $path = "/search/autocomplete";

    try {
      $validated = $httpRequest->validate([
        "q" => "required"
      ]);
      $q = $validated["q"];

      $body = [
        "q" => $q,
        "limit" => "10"
      ];
      $body = json_encode($body);

      $data = $this->fetchData($path, "GET", $body);

      return response()->json($data);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }

  public function getHotels(HttpRequest $httpRequest)
  {
    $data = null;
    $path = "/search/hotels";


    try {
      $validated = $httpRequest->validate([
        "typeSearch" => "required|in:destination",
        "destination" => "required",
        "destination.latitude" => "required|numeric",
        "destination.longitude" => "required|numeric",
        "destination.radius" => "required|numeric",
        "destination.city" => "required|string",
      ]);

      $destination = $validated["destination"];
      $body = [
        "startDate" => date("Y-m-d"),
        "endDate" => date("Y-m-d", strtotime("+7 days")),
        "destination" => $destination,
        "occupancies" => [
          [
            "rooms" => 1,
            "adults" => 1,
            "children" => 0
          ]
        ]
      ];

      $data = $this->fetchData($path, "GET", json_encode($body));

      return response()->json($data);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }

  public function getEvents(HttpRequest $httpRequest)
  {
    $data = null;
    $path = "/search/events";

    try {
      $validated = $httpRequest->validate([
        "typeSearch" => "required|in:destination,performer,venue",
        "destination" => "sometimes",
        "destination.lat" => "nullable|numeric",
        "destination.lng" => "nullable|numeric",
        "destination.radius" => "nullable|numeric",
        "destination.city" => "nullable|string",
        "performerId" => "sometimes|string",
        "venueId" => "sometimes|string",
      ]);

      $typeSearch = $validated["typeSearch"];
      $destination = null;

      if ($typeSearch === "destination") {
        if ($validated["destination"] === null) {
          return response()->json(null);
        }

        $destination = $validated["destination"];
        $body = [
          "startDate" => date("Y-m-d"),
          "endDate" => date("Y-m-d", strtotime("+7 days")),
          "searchType" => "destination",
          "withPerformers" => false,
          "destination" => $destination
        ];

        $data = $this->fetchData($path, "GET", json_encode($body));

        return response()->json($data);
      }

      if ($typeSearch === "performer") {
        if ($validated["performerId"] === null) {
          return response()->json(null);
        }

        $performerId = $validated["performerId"];
        $body = [
          "searchType" => "performer",
          "performerId" => $performerId,
          "withPerformers" => false
        ];

        $data = $this->fetchData($path, "GET", json_encode($body));

        return response()->json($data);
      }

      if ($typeSearch === "venue") {
        if ($validated["venueId"] === null) {
          return response()->json(null);
        }

        $venueId = $validated["venueId"];
        $body = [
          "searchType" => "venue",
          "venueId" => $venueId,
          "withPerformers" => false
        ];

        $data = $this->fetchData($path, "GET", json_encode($body));

        return response()->json($data);
      }

      return response()->json(null);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }

  public function getAutocomplete()
  {
    try {
      $body = '{
          "q": "Dallas",
          "limit": "10"
        }';
      var_dump($body);
      $data = $this->fetchData("/search/autocomplete", "GET", $body);

      return response()->json($data);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
    }
  }
}
