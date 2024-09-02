<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StageType;
use Illuminate\Http\Request;

class ApiStageTypeController extends Controller
{
    public function index() {
        $stages= StageType::all();
        return  response()->json($stages);
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required|string|max:255','role' => 'required|string|max:255']);
        $stage= StageType::create($request->all());
        return response()->json($stage);
    }

    public function show($id) {
        $stage= StageType::findOrFail($id);
        return  response()->json($stage);
    }

    public function update(Request $request, $id) {
        $request->validate(['name' => 'required|string|max:255','role' => 'required|string|max:255']);
        $stageType = StageType::findOrFail($id);
        $stageType->update($request->all());
        return $stageType;
    }

    public function destroy($id) {
        $stageType = StageType::findOrFail($id);
        $stageType->softDeletes();
        return response(['message'=>'soft delete successfuly']);
    }
}