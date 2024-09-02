<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use App\Models\StageType;
use Illuminate\Http\Request;

class ApiStageController extends Controller
{
    // Create
    public function store(Request $request) {
        $stage = Stage::create($request->all());
        return response()->json($stage, 201);
    }

   
  

    public function show($id ,Request $request) {
       $id=$request->id;
        $req_id=Request::where('id',$id )->first();
        $ST_id=$request->id;
        $req_id=StageType::where('id',$ST_id )->first();
        $stage = Stage::findOrFail($req_id);
        return response()->json($stage);
    }

    // Update
    public function update(Request $request, $id) {
        $stage = Stage::findOrFail($id);
        $stage->update($request->all());
        return response()->json($stage);
    }

    // Delete
    public function destroy($id) {
        Stage::destroy($id);
        return response()->json(null, 204);
    }
}