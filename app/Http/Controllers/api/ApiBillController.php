<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;

class ApiBillController extends Controller
{
    // Create a new bill
    public function store(Request $request) {
        // Validate and create a new bill
        $bill = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
        ]);
        $bill1 = Bill::create($bill);
        return response()->json($bill1, 201);
    }

    // Retrieve all bills
    public function index() {
        // Get all bills
        $bills = Bill::all();
        return response()->json($bills);
    }

    // Retrieve a specific bill
    public function show($id) {
        // Find and return the bill
        $bill = Bill::findOrFail($id);
        return response()->json($bill);
    }

    // Update a specific bill
    public function update(Request $request, $id) {
        // Find the bill and update it
        $bill = $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
        ]);
        $bill1 = Bill::findOrFail($id);
        $bill1->update($bill);
        return response()->json(['message'=>'updated successfully','bill' => $bill1]);
    }

    // Delete a specific bill
    public function destroy($id) {
        // Find and delete the bill
        $bill = Bill::find($id);
        $bill->softDeletes();
     
        return response()->json(['message' => 'deleted successfully']); // Return success message
    }
}
