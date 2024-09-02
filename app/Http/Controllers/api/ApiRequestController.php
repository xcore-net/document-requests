<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Request as ClientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiRequestController extends Controller
{
    public function getUserRequests(): JsonResponse
    {
        $client = Client::find(Auth::id());
        $requests = $client->requests;
        return response()->json($requests);
    }

    public function getUserRequest($id): JsonResponse
    {
        $client = Client::find(Auth::id());
        $request = $client->requests->find($id);
        if ($request) {
            return response()->json($request);
        }
        return response()->json(['message' => 'Request not found.'], 404);
    }

    public function createUserRequest(Request $request): JsonResponse
    {
        $requests = ClientRequest::all();
        $data = $request->validate([
            'name' => ['required', 'string'],
            'request_type_id' => ['required', 'exists:request_types,id'],
        ]);

        $clientRequest = ClientRequest::create([...$data, 'client_id' => Auth::id()]);
        $requestType = $clientRequest->requestType;

        $stagesTypes = $requestType->stageTypes;

        foreach ($stagesTypes as $type) {
            $clientRequest->stages()->create([
                'stage_type_id' => $type->id,
                'name' => $type->name,
                'role' => $type->role,
                'type' => $type->type,
                'order' => $type->pivot->order
            ]);
        }
        $taskController = new ApiTaskController;

        $taskController->addTask($clientRequest);

        //     $initialstage = $clientRequest->where('order', 1)->first();

        //     if ($initialstage->isForClient) {
        //         $performer_id = Auth::id();
        //         $assigner_id = null;
        //     } else {
        //         $performer_id = null;
        //         $assigner_id = null;
        //     }
        //     $initialstage->task->create(['user_id' => $performer_id, 'assigned_by' => $assigner_id]);

        return response()->json(['message' => 'Request created.'], 201);
    }

    //only cancels request
    public function updateUserRequest(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:canceled'],
        ]);

        $client = Client::find(Auth::id());
        $request = $client->requests->find($id);

        if ($request) {
            $request->update($data);
            return response()->json(['message' => 'Request canceled.'], 200);
        }

        return response()->json(['message' => 'Request not found.'], 404);
    }
    //for Employees
    public function getRequests(): JsonResponse
    {
        $requests = ClientRequest::all();
        return response()->json($requests, 200);
    }
    public function getActiveRequests(): JsonResponse
    {
        $requests = ClientRequest::where('status', ['inProgress']);

        if ($requests) {
            return response()->json($requests, 200);
        }

        return response()->json(['message' => 'Requests not found.'], 404);
    }
    public function getArchivedRequests(): JsonResponse
    {
        $requests = ClientRequest::where('status', ['completed', 'rejected', 'canceled']);

        if ($requests) {
            return response()->json($requests, 200);
        }

        return response()->json(['message' => 'Requests not found.'], 404);
    }
    public function getRequest($id): JsonResponse
    {
        $request = ClientRequest::find($id);

        if ($request) {
            return response()->json($request, 200);
        }

        return response()->json(['message' => 'Request not found.'], 404);
    }
}
