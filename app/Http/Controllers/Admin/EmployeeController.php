<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $list = Employee::latest()->paginate(10);

        return view('admin.employee.index', compact('list'));
    }

    public function create(EmployeeRequest $request)
    {
        Employee::create([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return redirect()->route('employee-list')->with('success', 'Çalışan Başarıyla Oluşturuldu');
    }

    public function show(Employee $employee)
    {
        return view('admin.employee.show', compact('employee'));
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->name  = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->save();

        return redirect()->route('employee-show', ['employee' => $employee->id])
            ->with('success', 'Çalışan Başarıyla Güncellendi');
    }
}
