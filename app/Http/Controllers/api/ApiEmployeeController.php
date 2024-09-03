<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiEmployeeController extends Controller
{
    public function getAllEmployee(): JsonResponse
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    public function getEmployee($id): JsonResponse
    {
        $employee = Employee::find($id);

        if ($employee) return response()->json(['message' => 'Employee not found.'], 404);

        return response()->json($employee);
    }

    public function createEmployee(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => ['required', 'exists:users,id', 'unique:employees,id'],
            'dept_id' => ['required', 'exists:departments,id'],
            'salary' => ['required', 'numeric', 'min:0'],
            'position' => ['required', 'in:Junior,Senior']
        ]);

        $user = User::find($data['id']);
        $user->assignRole('employee');

        Employee::create($data);

        return response()->json(['message' => 'Employee created.'], 201);
    }

    public function updateEmployee(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'dept_id' => ['sometimes', 'required', 'exists:departments,id'],
            'salary' => ['sometimes', 'required', 'numeric', 'min:0'],
            'position' => ['sometimes', 'required', 'in:Junior,Senior'],
        ]);

        $employee = Employee::find($id);

        if (!$employee)
            return response()->json(['message' => 'Employee not found.'], 404);

        $employee->update($data);
        return response()->json(['message' => 'Employee updated.'], 200);
    }

    public function deleteEmployee($id): JsonResponse
    {
        $employee = Employee::find($id);

        if ($employee)
            return response()->json(['message' => 'Employee not found.'], 404);

        $employee->deletes();
        return response()->json(['message' => 'Employee deteted.'], 200);
    }
}
