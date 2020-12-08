<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;

class EmployeeController extends Controller
{
    public function index()
    {
        $list = Employee::latest()->paginate(10);

        return view('admin.employee.index', compact('list'));
    }

    public function create(EmployeeRequest $request): RedirectResponse
    {
        Employee::create($request->toArray());

        return redirect()->route('employee-list')->with('success', 'Çalışan Başarıyla Oluşturuldu');
    }

    public function show(Employee $employee)
    {
        return view('admin.employee.show', compact('employee'));
    }

    public function update(EmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $employee->update($request->toArray());

        return redirect()->route('employee-show', ['employee' => $employee->id])
            ->with('success', 'Çalışan Başarıyla Güncellendi');
    }
}
