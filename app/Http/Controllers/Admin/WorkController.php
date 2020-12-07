<?php

namespace App\Http\Controllers\Admin;

use App\Enums\WorkPeriodEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkRequest;
use App\Models\City;
use App\Models\County;
use App\Models\Employee;
use App\Models\Job;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WorkController extends Controller
{
    public function index()
    {
        $list = Job::latest()->paginate(10);

        $employees = Employee::all();
        $cities    = City::all();

        return view('admin.job.index', compact('list', 'employees', 'cities'));
    }

    public function create(WorkRequest $request): RedirectResponse
    {
        Job::create([
            'name'        => $request->name,
            'description' => $request->description,
            'employee_id' => $request->employee_id,
            'city_id'     => $request->city_id,
            'county_id'   => $request->county_id,
            'address'     => $request->address,
            'date'        => Carbon::parse($request->date)->format('Y-m-d'),
            'started_at'  => WorkPeriodEnum::periods[$request->period]['start'],
            'finished_at' => WorkPeriodEnum::periods[$request->period]['end'],
        ]);

        return redirect()->route('job-list')->with('success', 'İş Başarıyla Oluşturuldu');
    }

    public function show(Job $job)
    {
        $employees = Employee::all();
        $cities    = City::all();

        return view('admin.job.show', compact('job', 'employees', 'cities'));
    }

    public function update(WorkRequest $request, Job $job): RedirectResponse
    {
        $job->name        = $request->name;
        $job->description = $request->description;
        $job->employee_id = $request->employee_id;
        $job->city_id     = $request->city_id;
        $job->county_id   = $request->county_id;
        $job->address     = $request->address;
        $job->date        = Carbon::parse($request->date)->format('Y-m-d');
        $job->started_at  = WorkPeriodEnum::periods[$request->period]['start'];
        $job->finished_at = WorkPeriodEnum::periods[$request->period]['end'];
        $job->save();

        return redirect()->route('job-show', ['job' => $job->id])
            ->with('success', 'İş Başarıyla Güncellendi');
    }

    public function getCounties(Request $request)
    {
        $counties = County::where('city_id', $request->city_id)->get();

        return view('admin.job.counties', compact('counties'));
    }
}
