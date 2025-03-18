<?php
namespace App\Repositories;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function createComment(array $data): Comment;
    public function getCommentById(int $id): ?Comment;
    public function updateComment(int $id, array $data): bool;
    public function deleteComment(int $id): bool;
}
