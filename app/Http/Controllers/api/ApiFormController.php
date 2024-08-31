<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiFormController extends Controller
{
    public function getAllForms(): JsonResponse
    {
        $forms = Form::all();
        return  response()->json($forms);
    }

    public function getForm($id): JsonResponse
    {
        $form = Form::find($id);

        if ($form) {
            return  response()->json($form);
        }

        return response()->json(['message' => 'From not found.'], 404);
    }

    public function createForm(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
        ]);

        Form::create($data);

        return response()->json(['message' => 'Form created.'], 201);
    }

    public function updateForm(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
        ]);

        $form = Form::find($id);

        if ($form) {
            $form->update($data);
            return response()->json(['message' => 'Form updated.'], 200);
        }

        return response()->json(['message' => 'From not found.'], 404);
    }

    public function deleteForm($id): JsonResponse
    {
        $form = Form::find($id);

        if ($form) {
            $form->delete();
            return response()->json(['message' => 'Form deteted.'], 200);
        }
        
        return response()->json(['message' => 'From not found.'], 404);
    }
}
