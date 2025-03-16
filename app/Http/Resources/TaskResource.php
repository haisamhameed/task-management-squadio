<?php

namespace App\Http\Resources;

use App\Enums\TaskStatus;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => TaskStatus::from($this->status)->label(),
            'due_date' => $this->due_date,
            'assigned_users' => $this->whenLoaded('assignedUsers', function () {
                return UserResource::collection($this->assignedUsers);
            }),
        ];
    }
}
