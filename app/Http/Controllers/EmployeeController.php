<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function show($id): View
    {
        $employee = Employee::find($id);
        return view('employee.index', ['employee' => $employee]);
    }
    public function create(): View
    {
        return view('employee.create');
    }
    public function store(Request $request):RedirectResponse
    {
        Employee::create([
            'father_name' => $request->fatherName,
            'mother_name' => $request->motherName,
            'position' => $request->position,
            'salary' => $request->address,
            'certificate' => $request->certificate,
            
        $table->integer('national_number');
        ]);

        return redirect('department.index');
    }
}
