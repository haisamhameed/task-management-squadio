<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'task_id' => $this->task_id,
            'comment' => $this->comment,
            'author' => $this->whenLoaded('author', function () {
                return new UserResource($this->author);
            }),
            'task' => $this->whenLoaded('task', function () {
                return new TaskResource($this->task);
            }),
        ];
    }
}
