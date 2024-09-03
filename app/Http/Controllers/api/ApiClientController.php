<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiClientController extends Controller
{
    public function getAllClients(): JsonResponse
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    public function getClient($id): JsonResponse
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        return response()->json($client);
    }

    public function createClient(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => ['required', 'exists:users,id', 'unique:clients,id'],
        ]);

        Client::create($data);

        return response()->json(['message' => 'Client created.'], 201);
    }

    public function updateClient(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'id' => ['sometimes', 'required', 'exists:users,id', 'unique:clients,id']
        ]);

        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        $client->update($data);
        return response()->json(['message' => 'Client updated.'], 200);
    }

    public function deleteClient($id): JsonResponse
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found.'], 404);
        }

        $client->delete();
        return response()->json(['message' => 'Client deleted.'], 200);
    }
}
