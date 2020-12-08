<?php

namespace App\Http\Controllers;

use App\Enums\JobStatusEnum;
use App\Helpers\HttpResponse;
use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\UpdateJobStatusRequest;
use App\Jobs\JobPriorityUpdate;
use App\Models\Employee;
use App\Models\Job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = Auth::guard('api_token')->user();
    }

    public function login(Request $request): JsonResponse
    {
        if (Auth::guard('api')->attempt($request->only('email', 'password'))) {

            $auth = Auth::guard('api')->user();

            $employee            = Employee::where('id', $auth->id)->first();
            $employee->api_token = hash('sha256', uniqid() . Str::random(100));
            $employee->save();

            return HttpResponse::success($employee->only(['name', 'email', 'api_token']));
        }

        return HttpResponse::error(Response::HTTP_UNAUTHORIZED);
    }

    public function jobList(): JsonResponse
    {
        $jobs = Job::where('employee_id', $this->user->id)
            ->where('date', Carbon::now()->format('Y-m-d'))
            ->orderBy('started_at', 'DESC')
            ->orderBy('priority', 'ASC')
            ->get();

        return HttpResponse::success($jobs->toArray());
    }

    public function updateJobStatus(UpdateJobStatusRequest $request, Job $job): JsonResponse
    {
        $job->status = JobStatusEnum::STATUSES[$request->status];
        $job->save();

        return HttpResponse::success($job->toArray());
    }

    public function createJob(CreateJobRequest $request): JsonResponse
    {
        $job = Job::create($request->toArray());

        JobPriorityUpdate::dispatch($request->employee_id);

        return HttpResponse::success($job->toArray());
    }
}
