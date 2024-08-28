<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::all();
        return view('department.index', ['departments' => $departments]);
    }
    public function show($id): View
    {
        $department = Department::find($id);
        return view('department.index', ['department' => $department]);
    }
    public function create(): View
    {
        return view('department.create');
    }
    public function store(Request $request):RedirectResponse
    {
        Department::create([
            'name' => $request->name,
            'address' => $request->address
        ]);

        return redirect('department.index');
    }
    public function edit($id): View
    {
        $department = Department::find($id);
        return view('department.create', ['department' => $department]);
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $department = Department::find($id);

        $department->update(
            [
                'name' => $request->name,
                'address' => $request->address
            ]
        );
        return redirect('department.index');
    }
    public function delete($id): RedirectResponse
    {
        $department = Department::find($id);

        $department->delete();
        return redirect('department.index');
    }
}
