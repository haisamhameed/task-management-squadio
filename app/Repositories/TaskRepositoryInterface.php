<?php
namespace App\Repositories;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function createTask(array $data): Task;
    public function getTaskById(int $id): ?Task;
    public function updateTask(int $id, array $data): bool;
    public function deleteTask(int $id): bool;
}
