<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Notifications\AlertNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTaskController extends Controller
{
    public function getUserTasks(): JsonResponse
    {
        $user = auth::user();
        $tasks = $user->tasks;
        return response()->json($tasks, 200);
    }
    public function getUserTask($id): JsonResponse
    {
        $user = auth::user();
        $task = $user->tasks->find($id);

        if (!$task) return response()->json(['message' => 'Task not found.'], 404);

        return response()->json($task, 200);
    }
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
            return response()->json(['message' => 'User does not has the required role .'], 400);

        $task->user_id = $user;
        $task->assigned_by = Auth::id();

        $user->notify(new AlertNotification('You have new task.'));

        return response()->json(['message' => 'Task assigned.'], 200);
    }
    public function receiveTask($task_id): JsonResponse
    {
        $user = Auth::user();
        $task = Task::find($task_id);

        if (!$task) return response()->json(['message' => 'Task not found.'], 404);

        if ($task->role != $user->role) return response()->json(['message' => 'User does not has the required role .'], 400);

        $task->user_id = $user->id;
        $task->assigned_by = $user->id;
        $task->save();

        return response()->json(['message' => 'Task received.'], 200);
    }
    public function controlTask($id, $action): JsonResponse
    {
        $user = Auth::user();
        $task = $user->task::find($id);

        if (!$task) return response()->json(['message' => 'User task not found.'], 404);

        $clientRequest = $task->stage->request;

        switch ($action) {
            case 'complete':
                $this->advanceTask($task);
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
    public function addTask($clientRequest)
    {
        $stage = $clientRequest->stages->where('order', $clientRequest->currentStage)->first();

        if ($stage->isForClient) {
            $performer_id = Auth::id();
            $assigner_id = null;
        } else {
            $performer_id = null;
            $assigner_id = null;
        }
        $stage->task->create(['user_id' => $performer_id, 'assigned_by' => $assigner_id]);
        return;
    }
    public function advanceTask($task)
    {
        $clientRequest = $task->stage->request;

        $task->stage->status = 'completed';
        $task->save();

        $currentStage = $clientRequest->currentStage;

        $client = $clientRequest->client;

        if ($currentStage == $clientRequest->stages->count()) {
            $clientRequest->status = 'completed';
            $client->user->notify(new AlertNotification('Request Completed'));
        } else {
            $currentStage++;
            $clientRequest->currentStage = $currentStage;
            $this->addTask($clientRequest);
        }

        $clientRequest->save();
        return;
    }
}
