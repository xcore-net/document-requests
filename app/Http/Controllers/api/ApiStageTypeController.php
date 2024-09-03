<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\StageType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiStageTypeController extends Controller
{

    public function getAllStageTypes(): JsonResponse
    {
        $stages = StageType::all();
        return  response()->json($stages);
    }

    public function getstagetype($id): JsonResponse
    {
        $stage = StageType::find($id);

        if ($stage) {
            return  response()->json($stage);
        }

        return response()->json(['message' => 'Stage type not found.'], 404);
    }

    public function createStageType(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'role' => ['required', 'string'],
            'type' => ['required', 'in:fill,pay,check,observe'],
            'isForClient' => ['boolean'],
        ]);

        StageType::create($data);

        return response()->json(['message' => 'Stage type created.'], 201);
    }

    public function updateStageType(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => ['sometimes','required', 'string'],
            'role' => ['sometimes','required', 'string'],
            'type' => ['sometimes','required', 'in:fill,pay,check,observe'],    
            'isForClient' => ['sometimes','boolean'],
        ]);

        $stage = StageType::find($id);

        if ($stage) {
            $stage->update($data);
            return response()->json(['message' => 'Stage type updated.'], 200);
        }

        return response()->json(['message' => 'Stage type not found.'], 404);
    }

    public function deleteStageType($id): JsonResponse
    {
        $stage = StageType::find($id);

        if ($stage) {
            $stage->delete();
            return response()->json(['message' => 'Stage type soft deteted.'], 200);
        }

        return response()->json(['message' => 'Stage type not found.'], 404);
    }
}
