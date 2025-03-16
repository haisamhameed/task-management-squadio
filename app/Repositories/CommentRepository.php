<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    public function createComment(array $data): Comment
    {
        $data['user_id'] = auth()->id();
        return Comment::create($data);
    }

    public function getCommentById(int $id): ?Comment
    {
        return Comment::find($id);
    }

    public function updateComment(int $id, array $data): bool
    {
        return Comment::where('id', $id)->update($data);
    }

    public function deleteComment(int $id): bool
    {
        return Comment::destroy($id) > 0;
    }
}