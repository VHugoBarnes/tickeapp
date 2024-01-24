<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getAutocomplete() {
      $BASE_URL = env("API_BASE_URL");
      $API_KEY = env("API_KEY");

      $httpClient = new Client();

      $headers = [
        "Accept" => "application/json",
        "Content-Type" => "application/json",
        "Authorization" => "Bearer $API_KEY"
      ];
      $body = '{
        "q": "Dallas",
        "limit": "10"
      }';

      try {
        $request = new Request("GET", "$BASE_URL/search/autocomplete", $headers, $body);
      $res = $httpClient->sendAsync($request)->wait();
      $resBody = $res->getBody()->getContents();

      $data = json_decode($resBody, true);

      return response()->json($data);
      } catch(\Exception $e) {
        // Handle exceptions, if any
        return response()->json(['error' => $e->getMessage()], 500);
      }
    }
}
