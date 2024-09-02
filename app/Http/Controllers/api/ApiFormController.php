<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;

class ApiFormController extends Controller
{
    public function index() {
        // Retrieve all forms
        $forms = Form::all();
        return response()->json(['forms' => $forms]);
    }

    public function store(Request $request) {
        // Validate and create a new form
        $request->validate(['title' => 'required|string','description' => 'required|string']);
        $form = Form::create($request->all());
        return response()->json(['message' => 'Form stored successfully', 'form' => $form], 201); // Added status code
    }

    public function show($id) {
        // Retrieve a specific form by ID
        $form = Form::findOrFail($id);
        return response()->json(['form' => $form]);
    }

    public function update(Request $request, $id) {
        // Validate and update the specified form
        $request->validate(['name' => 'required|string','description' => 'required|string']);
        $form = Form::findOrFail($id);
        $form->update($request->all());
        return response()->json(['message' => 'Form updated successfully', 'form' => $form]);
    }

    public function destroy($id) {
        // Delete the specified form
        $form = Form::findOrFail($id);
        $form->delete();
        return response()->json(['message' => 'Form deleted successfully'], 204); // Added status code
    }
}