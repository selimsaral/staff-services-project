<?php

namespace App\Jobs;

use App\Helpers\Google\Direction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DirectionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $locations;

    private string $origin;

    public function __construct(array $locations)
    {
        $this->locations = $locations;

        $this->setOrigin();
    }

    public function setOrigin()
    {

        $locations = collect($this->locations);
        $origin    = $locations->first();

        $this->origin = $origin;

        $this->locations = $locations->reject(function ($value, $key) use ($origin) {
            return $value == $origin;
        })->toArray();
    }

    public function handle()
    {
        $direction = new Direction();

        return $direction
            ->setOrigin($this->origin)
            ->setDestination($this->origin)
            ->setWayPoints($this->locations)
            ->run()
            ->getRoutes();
    }
}
