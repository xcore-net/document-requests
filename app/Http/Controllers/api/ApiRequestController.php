<?php
namespace App\Http\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Request as ClientRequest;
use App\Models\RequestType;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Validator;

class ApiRequestController extends Controller
{

    //for user

   
    public function index()
    {
        $id = Auth::id(); // Changed to get the authenticated user's ID
        $requests = ClientRequest::where('client_id', $id)->get(); // Changed to get all requests for the client
        return response()->json(['requests'=>$requests]);
    }

    // Store a newly created request    // Store a newly created request
    public function store(Request $request)
    {
        $request_type_id = RequestType::find($request->request_type_id); // Retrieve the RequestType by ID from the request
        $id = Auth::id(); // Get the authenticated user's ID
        $request->validate([
            'title' => ['required', 'string'],
            'status' => ['required', 'in:inprogress,completed'],
            'current_stage' => ['required', 'integer',],
            'request_type_id' => ['required', 'integer','exists:request_types,id'],
            'client_id' => ['required', 'integer','exists:clients,id'],
        ]);
        $newRequest = ClientRequest::create([ // Changed variable name to avoid confusion
            'title' => $request->title, // Corrected to use $request->title
            'status' => $request->status,
            'current_stage' => $request->current_stage,
            'request_type_id' => $request_type_id->id, // Use the correct property from the RequestType model
            'client_id' => $id, // Use the authenticated user's ID
        ]);
        return response()->json(['message' => 'stored successfully', 'request' => $newRequest]);
    }
    // Display a specific request
    public function show($id)
    {
        $request = ClientRequest::findOrFail($id); // Changed to use findOrFail to retrieve the specific request

        return response()->json($request);
    }

    // Update a specific request


    public function update(Request $request, $id) // Changed HttpRequest to Request
    {
        $existingRequest = ClientRequest::findOrFail($id);
        
        $request->validate([ // Moved validation before retrieving request_type_id
            'title' => ['required', 'string'],
            'status' => ['required', 'in:inprogress,completed'],
            'current_stage' => ['required', 'integer'],
            'request_type_id' => ['required', 'integer'],
            'client_id' => ['required', 'integer'],
        ]);

        $request_type_id = RequestType::findOrFail($request->request_type_id); // Changed to use findOrFail for better error handling
        $client_id = Auth::id(); // Get the authenticated user's ID

        $existingRequest->update([ // Changed variable name to avoid confusion
            'title' => $request->title, // Corrected to use $request->title
            'status' => $request->status,
            'current_stage' => $request->current_stage,
            'request_type_id' => $request_type_id->id, // Use the correct property from the RequestType model
            'client_id' => $client_id, // Use the authenticated user's ID
        ]);

        return response()->json($existingRequest);
    }

    // Remove a specific request
    public function destroy($id)
    {
        $request = ClientRequest::find($id);

        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        $request->delete();

        return response()->json(['message' => 'Request deleted successfully']);
    }

//for employee
    public function getRequests() 
    {
        $requests = ClientRequest::all();
        return response()->json($requests, 200);
    }
    public function getActiveRequests()
    {
        $requests = ClientRequest::where('status', ['inProgress']);

        if ($requests) {
            return response()->json($requests, 200);
        }

        return response()->json(['message' => 'Requests not found.'], 404);
    }
    public function getArchivedRequests()
    {
        $requests = ClientRequest::where('status', ['completed', 'rejected', 'canceled']);

        if ($requests) {
            return response()->json($requests, 200);
        }

        return response()->json(['message' => 'Requests not found.'], 404);
    } 
    public function getRequest($id)
    {
        $request = ClientRequest::find($id);

        if ($request) {
            return response()->json($request, 200);
        }

        return response()->json(['message' => 'Request not found.'], 404);
    }
}
