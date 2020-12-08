<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobRequest;
use App\Jobs\JobPriorityUpdate;
use App\Models\City;
use App\Models\County;
use App\Models\Employee;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $list = Job::latest()->paginate(10);

        $employees = Employee::all();
        $cities    = City::all();

        return view('admin.job.index', compact('list', 'employees', 'cities'));
    }

    public function create(JobRequest $request): RedirectResponse
    {
        Job::create($request->toArray());

        JobPriorityUpdate::dispatch($request->employee_id);

        return redirect()->route('job-list')->with('success', 'İş Başarıyla Oluşturuldu');
    }

    public function show(Job $job)
    {
        $employees = Employee::all();
        $cities    = City::all();

        return view('admin.job.show', compact('job', 'employees', 'cities'));
    }

    public function update(JobRequest $request, Job $job): RedirectResponse
    {
        $job->update($request->toArray());

        JobPriorityUpdate::dispatch($request->employee_id);

        return redirect()->route('job-show', ['job' => $job->id])
            ->with('success', 'İş Başarıyla Güncellendi');
    }

    public function getCounties(Request $request)
    {
        $counties = County::where('city_id', $request->city_id)->get();

        return view('admin.job.counties', compact('counties'));
    }
}
