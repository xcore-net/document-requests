<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\RequestType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiRequestTypeController extends Controller
{
    public function getRequestTypes(): JsonResponse
    {
        $requestTypes = RequestType::all();
        return response()->json($requestTypes);
    }
    public function getRequestType($id): JsonResponse
    {
        $requestType = RequestType::find($id);
        return response()->json($requestType);
    }
    public function createRequestType(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'form_id' => ['required', 'exists:forms,id'],
            'bill_id' => ['required', 'exists:bills,id'],
            'stage_ids' => ['nullable', 'array'],
            'stage_ids.*' => ['exists:stage_types,id']
        ]);

        $requestType = RequestType::create($data);

        $stage_ids = $data['stage_ids'];

        if ($stage_ids) {
            $response = $this->attachStages($request, $requestType);

            if ($response) {
                return $response;
            }
        }

        return response()->json(['message' => 'Request type created.'], 201);
    }
    public function updateRequestType(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string'],
            'form_id' => ['sometimes', 'required', 'exists:forms,id'],
            'bill_id' => ['sometimes', 'required', 'exists:bills,id'],
            'stage_ids' => ['sometimes', 'array'],
            'stage_ids.*' => ['exists:stage_types,id'],
        ]);

        $requestType = RequestType::find($id);

        if ($requestType) {
            $requestType->update($data);
            return response()->json(['message' => 'Request type updated.'], 200);
        }

        return response()->json(['message' => 'Request type not found.'], 404);
    }
    public function deleteRequestType($id): JsonResponse
    {
        $requestType = RequestType::find($id);

        if ($requestType) {
            $requestType->delete();
            return response()->json(['message' => 'Request type soft deleted.'], 200);
        }

        return response()->json(['message' => 'Request type not found.'], 404);
    }
    //stages
    public function addStages(Request $request, $id): JsonResponse
    {
        $requestType = RequestType::find($id);
        if ($requestType) {
            $response = $this->attachStages($request, $requestType);

            if ($response) {
                return $response;
            }
            return response()->json(['message' => 'Stages added.'], 200);
        }
        return response()->json(['message' => 'Request type not found.'], 404);
    }
    //gpt generated code below. review needed 
    public function addStage(Request $request, $id)
    {
        $data = $request->validate([
            'stage_id' => ['required', 'exists:stage_types,id'],
            'order' => ['required', 'integer', 'min:1'],
        ]);
        $requestType = RequestType::find($id);

        if ($requestType) {

            $stage_id = $data['stage_id'];
            $newOrder = $data['order'];

            // Check if the stage already exists in the pivot table
            if ($requestType->stageTypes->where('stage_id', $stage_id)->exists()) {
                return response()->json(['message' => 'Stage already exists.'], 400);
            }

            // Get the current stages and adjust their order
            $stages = $requestType->stageTypes->orderBy('pivot_order')->get();

            foreach ($stages as $stage) {
                if ($stage->pivot->order >= $newOrder) {
                    $stage->pivot->order++;
                    $stage->pivot->save();
                }
            }

            // Attach the new stage at the specified order
            $requestType->stageTypes->attach($stage_id, ['order' => $newOrder]);

            return response()->json(['message' => 'Stage added successfully.'], 200);
        }

        return response()->json(['message' => 'Request type not found.'], 404);
    }
    public function removeAllStages($id)
    {
        $requestType = RequestType::find($id);

        if ($requestType) {
            $requestType->stageTypes()->detach();

            return response()->json(['message' => 'All stages removed.'], 200);
        }

        return response()->json(['message' => 'Request type not found.'], 404);
    }
    public function removeStage(Request $request, $id)
    {
        $data = $request->validate([
            'stage_id' => ['required', 'exists:stage_types,id'],
        ]);
        $requestType = RequestType::find($id);

        if ($requestType) {

            $stage_id = $data['stage_id'];

            // Check if the stage exists in the pivot table
            if (!$requestType->stageTypes->where('stage_id', $stage_id)->exists()) {
                return response()->json(['message' => 'Stage not found.'], 404);
            }

            // Get the order of the stage to be removed
            $stageToRemove = $requestType->stageTypes->where('stage_id', $stage_id)->first();
            $removeOrder = $stageToRemove->pivot->order;

            // Remove the stage
            $requestType->stageTypes()->detach($stage_id);

            // Adjust the order of the remaining stages
            $stages = $requestType->stageTypes->orderBy('pivot_order')->get();

            foreach ($stages as $stage) {
                if ($stage->pivot->order > $removeOrder) {
                    $stage->pivot->order--;
                    $stage->pivot->save();
                }
            }

            return response()->json(['message' => 'Stage removed successfully.'], 200);
        }

        return response()->json(['message' => 'Request type not found.'], 404);
    }
    public function attachStages(Request $request, RequestType $requestType)
    {
        $data = $request->validate([
            'stage_ids' => ['required', 'array'],
            'stage_ids.*' => ['exists:stage_types,id'],
        ]);

        $stage_ids = $data['stage_ids'];

        // Check if any of the stage IDs already exist in the pivot table; notice:check later
        $existingStages = $requestType->stageTypes->whereIn('stage_id', $stage_ids)->pluck('stage_id')->toArray();

        if (!empty($existingStages)) {
            return response()->json(['message' => 'One or more stages already exist.', 'existing_stages' => $existingStages], 400);
        }

        $order = $requestType->stageTypes->count();

        foreach ($stage_ids as $stage_id) {
            $order++;
            $requestType->stageTypes()->attach($stage_id, ['order' => $order]);
        }

        return null; //indicate success
    }
}
