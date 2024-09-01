<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Request as ClientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiRequestController extends Controller
{
    public function getUserRequests(): JsonResponse
    {
        $user = Auth::user();
        $requests = $user->requests;
        return response()->json($requests);
    }

    public function getUserRequest($id): JsonResponse
    {
        $user = Auth::user();
        $request = $user->requests->find($id);
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
            'client_id' => ['required', 'exists:clients,id'],
            'request_type_id' => ['required', 'exists:request_types,id'],
        ]);

        ClientRequest::create($data);

        return response()->json(['message' => 'Request created.'], 201);
    }
    //only cancels request
    public function updateUserRequest(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:canceled'],
        ]);

        $user = Auth::user();
        $request = $user->requests->find($id);

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

    public function addStage(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'stage_id' => ['required', 'in:canceled'],
        ]);

        $user = Auth::user();
        $request = $user->requests->find($id);

        if ($request) {
            $request->update($data);
            return response()->json(['message' => 'Request canceled.'], 200);
        }

        return response()->json(['message' => 'Request not found.'], 404);
    }
}