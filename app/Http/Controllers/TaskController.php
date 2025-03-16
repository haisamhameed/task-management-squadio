<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Resources\TaskResource;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Requests\Task\AssignUserRequest;
use App\Repositories\TaskRepositoryInterface;

class TaskController extends Controller
{
    use ApiResponseTrait;
    private TaskRepository $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $tasks = $this->taskRepository->getAllTasks();
        return $this->successResponse('Tasks retrieved successfully', [
            'tasks' => TaskResource::collection($tasks),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $task = $this->taskRepository->createTask($data);
        return $this->successResponse('Task created successfully', [
            'task' => new TaskResource($task),
        ], 201);
    }

    public function update(UpdateRequest $request, $id) {
        $data = $request->validated();
        $task = $this->taskRepository->getTaskById($id);
        if (!$task) {
            return $this->errorResponse('Task not found', 404);
        }
        Gate::authorize('update', $task);
        $this->taskRepository->updateTask($id, $data);
        $task->refresh();
        return $this->successResponse('Task updated successfully', [
            'task' => new TaskResource($task),
        ]);
    }

    public function destroy($id)
    {
        $task = $this->taskRepository->getTaskById($id);
        if (!$task) {
            return $this->errorResponse('Task not found', 404);
        }
        Gate::authorize('delete', $task);
        $this->taskRepository->deleteTask($id);
        return $this->successResponse('Task deleted successfully');
    }

    public function assignUser(AssignUserRequest $request)
    {
        $data = $request->validated();
        $task = $this->taskRepository->getTaskById($data['task_id']);
        if (!$task) {
            return $this->errorResponse('Task not found', 404);
        }
        Gate::authorize('update', $task);
        $task->assignedUsers()->sync($data['user_id']);
        $task->load('assignedUsers');
        return $this->successResponse('User(s) assigned to task successfully', [
            'task' => new TaskResource($task),
        ]);

    }
}
