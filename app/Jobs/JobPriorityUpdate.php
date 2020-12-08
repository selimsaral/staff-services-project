<?php

namespace App\Jobs;

use App\Helpers\GetLocations;
use App\Models\Employee;
use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class JobPriorityUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $employee = Employee::where('id', $this->user_id)->first();
        $jobs     = $employee->notCompletedJobs->groupBy(['date', 'started_at']);

        foreach ($jobs as $day) { // Day: 07.12.2020, 08.12.2020

            foreach ($day as $key => $groupJob) { // Period: 12:00:00, 18:30:00

                $jobIds    = array();
                $locations = new GetLocations();

                $locations->setAddress($groupJob->first()->city->name);

                foreach ($groupJob as $job) {
                    $locations->setAddress($job->address);

                    $jobIds[md5($job->address)] = $job->id;
                }

                // Get Place ID For Address
                $placeIds = $locations->locationDetails()->getLocations();

                // Get Ordered Place ID
                $orderedLocations = DirectionJob::dispatchNow($placeIds);

                // Reverse Array Key And Value // Result; PlaceID => MD5(Address)
                $places = collect($placeIds)->mapWithKeys(function ($item, $key) {
                    $item = str_replace('place_id:', '', $item);
                    return [$item => $key];
                });

                // Update Priority For Job
                foreach ($orderedLocations as $key => $orderedLocation) {
                    if (isset($jobIds[$places[$orderedLocation]])) {
                        Job::where([
                            'id' => $jobIds[$places[$orderedLocation]]
                        ])->update(['priority' => $key]);
                    }
                }
            }
        }
    }
}
