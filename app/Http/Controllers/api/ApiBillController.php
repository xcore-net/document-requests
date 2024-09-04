<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiBillController extends Controller
{
    public function getAllBills(): JsonResponse
    {
        $bills = Bill::all();
        return response()->json($bills,200);
    }

    public function getBill($id): JsonResponse
    {
        $bill = Bill::find($id);

        if ($bill) {
            return response()->json($bill,200);
        }

        return response()->json(['message' => 'Bill not found.'], 404);
    }

    public function createBill(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'amount' => ['required', 'integer', 'min:0'],
        ]);

        Bill::create($data);

        return response()->json(['message' => 'Bill created.'], 201);
    }

    public function updateBill(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'amount' => ['required', 'integer', 'min:0'],
        ]);

        $bill = Bill::find($id);
        if ($bill) {
            $bill->update($data);
            return response()->json(['message' => 'Bill updated.'], 200);
        }

        return response()->json(['message' => 'Bill not found.'], 404);
    }

    public function deleteBill($id): JsonResponse
    {
        $bill = Bill::find($id);

        if ($bill) {
            $bill->delete();
            return response()->json(['message' => 'Bill soft deleted.'], 200);
        }

        return response()->json(['message' => 'Bill not found.'], 404);
    }
}
