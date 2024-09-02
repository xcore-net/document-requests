<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Form;
use App\Models\RequestType;
use Illuminate\Http\Request;

class ApiRequestTypeController extends Controller
{
 public function index(){
    $requestTypes=RequestType::all();
    return response()->json(['requestTypes' => $requestTypes]);
 }   

 public function show($id)
 {
     $requestType = RequestType::find($id);
     return response()->json($requestType);
 }

 public function store(Request $request){
   $bill_id = $request->bill_id; // Corrected to get bill_id from the request
   $bill = Bill::findOrFail($bill_id); // Changed to use findOrFail for better error handling
   
   $form_id = $request->form_id; // Corrected to get form_id from the request
   $form = Form::findOrFail($form_id); // Changed to use findOrFail for better error handling
   $request->validate([
      'name' => ['required', 'string'],
      'form_id' => ['required', 'integer','exists:forms,id'],
      'bill_id' => ['required', 'integer','exists:bills,id'],
  ]);
   $requestType = RequestType::create([
      'name' => $request->name,
      'bill_id' => $bill->id, 
      'form_id' => $form->id // Corrected to use the correct property from the Form model
  ]);
   return response()->json(['message' => 'stored successfully', 'requestType' => $requestType]);
} 

public function update(Request $request, $id){ // Added $id parameter to identify the RequestType
   $requestType = RequestType::findOrFail($id); // Retrieve the RequestType by ID
   $bill_id = $request->bill_id; // Corrected to get bill_id from the request
   $bill = Bill::where('id', $bill_id)->first();
   
   $form_id = $request->form_id; // Corrected to get form_id from the request
   $form = Form::where('id', $form_id)->first();
   
   $request->validate([
      'name' => ['required','string'],
      'form_id' => ['required','integer'],
      'bill_id'=> ['required','integer',]
  ]);
  $requestType->update([ // Use the retrieved $requestType
   'name' => $request->name,
   'bill_id' => $bill->id, // Use the correct property from the Bill model
   'form_id' => $form->id // Use the correct property from the Form model
  ]);
  return response()->json(['message'=>'updated successfully','requestType' => $requestType]);
}

public function destroy($id){ // Added destroy method to delete a RequestType
   $requestType = RequestType::findOrFail($id); // Retrieve the RequestType by ID
   $requestType->delete(); // Delete the RequestType
   return response()->json(['message' => 'deleted successfully']); // Return success message
}
// ... existing code ...
}
