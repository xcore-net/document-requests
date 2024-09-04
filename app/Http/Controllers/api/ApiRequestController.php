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
        if (!$client) return response()->json(['message' => 'User not a client.'], 404);

        $requests = $client->requests;
        return response()->json($requests);
    }

    public function getUserRequest($id): JsonResponse
    {
        $client = Client::find(Auth::id());
        if (!$client) return response()->json(['message' => 'User not a client.'], 404);

        $request = $client->requests->find($id);
        if ($request) {
            return response()->json($request);
        }
        return response()->json(['message' => 'Request not found.'], 404);
    }

    public function createUserRequest(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'request_type_id' => ['required', 'exists:request_types,id'],
        ]);

        $client = Client::find(Auth::id());
        if (!$client) return response()->json(['message' => 'User not a client.'], 404);

        $clientRequest = ClientRequest::create([...$data, 'client_id' => $client->id]);
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

        return response()->json(['message' => 'Request created.'], 201);
    }
    //only cancels request
    public function updateUserRequest(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:canceled'],
        ]);

        $client = Client::find(Auth::id());
        if (!$client) return response()->json(['message' => 'User not a client.'], 404);

        $request = $client->requests->find($id);

        if ($request) {
            $request->update($data);
            return response()->json(['message' => 'Request canceled.'], 200);
        }

        return response()->json(['message' => 'Request not found.'], 404);
    }
    public function pay($id): JsonResponse
    {
        $client = Client::find(Auth::id());
        if (!$client) return response()->json(['message' => 'User not a client.'], 404);

        $request = $client->requests->find($id);
        if (!$request)
            return response()->json(['message' => 'Request not found.'], 404);

        $request->payment->create();

        return response()->json(['message' => 'Payment made.'], 200);
    }
    public function fill($id): JsonResponse
    {
        $client = Client::find(Auth::id());
        if (!$client) return response()->json(['message' => 'User not a client.'], 404);

        $request = $client->requests->find($id);
        if (!$request)
            return response()->json(['message' => 'Request not found.'], 404);
        $request->form->create();

        return response()->json(['message' => 'Form filled.'], 200);
    }
    public function advance($id): JsonResponse
    {
        $client = Client::find(Auth::id());
        if (!$client) return response()->json(['message' => 'User not a client.'], 404);

        $request = $client->requests->find($id);
        if (!$request) return response()->json(['message' => 'Request not found.'], 404);

        $currentStage = $request->stages->where('order',$request->current_stage)->first();

        if(!$currentStage->isForClient){
            return response()->json(['message' => 'User does not have authority to advance current stage.'], 400);
        }
        else if($currentStage->task->type == 'fill'){
            if(!$request->filledForm) return response()->json(['message' => 'User must fill the form.'], 400);
            
        }
        else if($currentStage->task->type == 'pay'){
            if(!$request->payment) return response()->json(['message' => 'User must fill the form.'], 400);
        }

        $task = $currentStage->task;
        $taskController = new ApiTaskController;

        $taskController->advanceTask($task);

        return response()->json(['message' => 'Stage advanced.'], 200);
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
    public function getRequestForm($id): JsonResponse
    {
        $request = ClientRequest::find($id);

        if (!$request) return response()->json(['message' => 'Request not found.'], 404);

        $form = $request->form;
        return response()->json($form, 200);
    }
    public function getRequestBill($id): JsonResponse
    {
        $request = ClientRequest::find($id);

        if (!$request) return response()->json(['message' => 'Request not found.'], 404);

        $bill = $request->bill;
        return response()->json($bill, 200);
    }
    public function getRequestFilledForm($id): JsonResponse
    {
        $request = ClientRequest::find($id);

        if (!$request) return response()->json(['message' => 'Request not found.'], 404);

        $filledForm = $request->filledForm;

        if (!$filledForm) return response()->json(['message' => 'Filled form not found.'], 404);

        return response()->json($filledForm, 200);
    }
    public function getRequestPayment($id): JsonResponse
    {
        $request = ClientRequest::find($id);

        if (!$request) return response()->json(['message' => 'Request not found.'], 404);

        $payment = $request->payment;

        if (!$payment) return response()->json(['message' => 'Payment form not found.'], 404);

        return response()->json($payment, 200);
    }
}
