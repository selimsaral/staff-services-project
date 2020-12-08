<?php

namespace App\Helpers\Google;

use Illuminate\Support\Facades\Http;

class Direction
{
    private string $origin;

    private string $destination;

    private string $wayPoints;

    private array $response = [];

    const ENDPOINT = "https://maps.googleapis.com/maps/api/directions/json";

    const STATUS_SUCCESS = "OK";


    public function setWayPoints(array $wayPoints): Direction
    {
        $this->wayPoints = implode('|', $wayPoints);

        return $this;
    }

    public function setOrigin(string $origin): Direction
    {
        $this->origin = $origin;

        return $this;
    }

    public function setDestination(string $destination): Direction
    {
        $this->destination = $destination;

        return $this;
    }

    public function run(): Direction
    {
        $response = Http::get(self::ENDPOINT, [
            'key'         => config('google.API_KEY'),
            'origin'      => $this->origin,
            'destination' => $this->destination,
            'waypoints'   => "optimize:true|" . $this->wayPoints
        ])->json();

        $this->response = $response;

        return $this;
    }

    public function getResult(): array
    {
        return $this->response;
    }

    public function getRoutes()
    {
        $routes = [];
        if ($this->response['status'] == self::STATUS_SUCCESS) {

            foreach ($this->response['geocoded_waypoints'] as $route) {
                $routes[] = $route['place_id'];
            }

        }

        return $routes;
    }
}
