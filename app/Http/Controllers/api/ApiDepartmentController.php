<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiDepartmentController extends Controller
{

    public function getAllDepartments(): JsonResponse
    {
        $departments = Department::all();
        return response()->json($departments, 200);
    }
    public function getDepartment($id): JsonResponse
    {
        $department = Department::find($id);
        if (! $department) return response()->json('Department not found', 404);

        return response()->json($department, 200);
    }
    public function createDepartment($request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string']
        ]);

        Department::create($data);

        return response()->json('Department created', 201);
    }
    public function updateDepartment(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string']
        ]);

        $department = Department::find($id);

        if (! $department) return response()->json('Department not found', 404);

        $department->update($data);
        return response()->json('Department updated', 200);
    }
    public function deleteDepartment($id): JsonResponse
    {
        $department = Department::find($id);
        if (! $department) return response()->json('Department not found', 404);

        $department->delete();
        return response()->json('Department deleted', 200);
    }
}
