<?php

namespace App\Repositories;

use App\Models\Task;
use App\Enums\TaskStatus;

class TaskRepository implements TaskRepositoryInterface
{
    public function createTask(array $data): Task
    {
        $data['user_id'] = auth()->id();
        $data['status'] = TaskStatus::PENDING->value;
        return Task::create($data);
    }

    public function getTaskById(int $id): ?Task
    {
        return Task::select('id', 'title', 'description', 'status', 'due_date', 'user_id')
        ->with('assignedUsers:id,name,email', 'author:id,name,email')
        ->find($id);
    }

    public function updateTask(int $id, array $data): bool
    {
        return Task::where('id', $id)->update($data);
    }

    public function deleteTask(int $id): bool
    {
        return Task::destroy($id) > 0;
    }

    public function getAllTasks()   
    {
        return Task::select('id', 'title', 'description', 'status', 'due_date', 'user_id')
            ->where('user_id', auth()->id())
            ->with('assignedUsers:id,name,email', 'author:id,name,email')
            ->get();
    }
}