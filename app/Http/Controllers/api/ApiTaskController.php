<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTaskController extends Controller
{
    public function getTasks(): JsonResponse
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }
    public function getActiveTasks(): JsonResponse
    {
        $tasks = Task::where('status', ['inProgress,pending']);

        if (!$tasks)
            return response()->json(['message' => 'Tasks not found.'], 404);

        return response()->json($tasks, 200);
    }
    public function getArchivedTasks(): JsonResponse
    {
        $tasks = Task::where('status', ['completed', 'rejected', 'canceled']);

        if (!$tasks)
            return response()->json(['message' => 'Tasks not found.'], 404);

        return response()->json($tasks, 200);
    }
    public function getTask($id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task)
            return response()->json(['message' => 'Task not found.'], 404);

        return response()->json($task, 200);
    }
    public function assignTask($task_id, $user_id): JsonResponse
    {
        $task = Task::find($task_id);
        $user = User::find($user_id);

        if (!$task)
            return response()->json(['message' => 'Task not found.'], 404);
        if (!$user)
            return response()->json(['message' => 'User not found.'], 404);

        if ($task->role != $user->role)
            return response()->json(['message' => 'User doesn\'t has the required role .'], 400);

        $task->user_id = $user;
        $task->assigned_by = Auth::id();

        return response()->json(['message' => 'Task assigned.'], 200);
    }
    public function controlTask($id, $action): JsonResponse
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $clientRequest =  $task->stage->request;

        switch ($action) {
            case 'complete':
                $task->stage->status = 'completed';
                $task->save();

                $currentStage = $clientRequest->currentStage +1;
                $clientRequest->currentStage = $currentStage;
                $clientRequest->save();
                $this->addTask($clientRequest);
                return response()->json(['message' => 'Task completed.'], 200);
            case 'reject':
                $task->stage->status = 'rejected';
                $task->save();

                $clientRequest->status = 'rejected';
                $clientRequest->save();
                return response()->json(['message' => 'Task rejected.'], 200);
            case 'fail':
                $task->stage->status = 'failed';
                $task->save();

                $clientRequest->status = 'failed';
                $clientRequest->save();
                return response()->json(['message' => 'Task failed.'], 200);
            default:
                return response()->json(['message' => 'Invalid action'], 400);
        }
    }
    public function addTask($clientRequest){
        $initialstage = $clientRequest->stages->where('order', $clientRequest->currentStage)->first();

        if ($initialstage->isForClient) {
            $performer_id = Auth::id();
            $assigner_id = null;
        } else {
            $performer_id = null;
            $assigner_id = null;
        }
        $initialstage->task->create(['user_id' => $performer_id, 'assigned_by' => $assigner_id]);
        return;
    }
}
