<?php

namespace App\Helpers\Google;

use Illuminate\Support\Facades\Http;

class GeoLocation
{
    private string $address;

    private array $response;

    const ENDPOINT = "https://maps.googleapis.com/maps/api/geocode/json";
    const STATUS_SUCCESS = "OK";

    public function setAddress(string $address): GeoLocation
    {
        $this->address = $address;

        return $this;
    }

    public function run(): GeoLocation
    {
        $response = Http::get(self::ENDPOINT, [
            'key'     => config('google.API_KEY'),
            'address' => $this->address
        ])->json();

        $this->response = $response;

        return $this;
    }

    public function getResult(): array
    {
        return $this->response;
    }

    public function getLocation()
    {
        if ($this->response['status'] == self::STATUS_SUCCESS) {

            return "place_id:" . $this->response['results'][0]['place_id'];
        }
    }
}
